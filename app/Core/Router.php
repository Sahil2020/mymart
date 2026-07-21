<?php
/**
 * 
 * Route
 * │
 * ├── uri = "/dashboard"
 * │
 * ├── method = GET
 * │
 * ├── action
 * │      │
 * │      ├── DashboardController::class
 * │      └── index
 * │
 * └── middlewares
 *        │
 *        └── AuthMiddleware::class
 * 
 */

declare(strict_types=1);

namespace App\Core;
use ReflectionMethod;
use ReflectionNamedType;

class Router
{
    private array $routes = [];

    public function get(string $uri, array $action): Route
    {
        return $this->addRoute('GET', $uri, $action);
    }

    public function post(string $uri, array $action): Route
    {
        return $this->addRoute('POST', $uri, $action);
    }

    private function addRoute(string $method, string $uri, array $action): Route
    {
        $route = new Route($uri, $method, $action);
        $this->routes[$method][$uri] = $route;
        return $route;
    }

    public function dispatch(string $uri): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // if (!isset($this->routes[$method][$uri])) {
        //     http_response_code(404);
        //     require APP_PATH . '/Views/errors/404.php';
        //     exit;
        // }

        // /** @var Route $route */
        // $route = $this->routes[$method][$uri];
        $route = $this->findRoute($method, $uri);

        if (!$route) {
            throw new \Exception('Route not found');
        }

        [$controller, $action] = $route->action;

        $container = new Container();

        $instance = $container->make($controller);

        // Middleware execution will be added here in the next step
        foreach ($route->middlewares as $middleware) {

            $middlewareInstance = $container->make($middleware);

            $middlewareInstance->handle();

        }

        $reflectionMethod = new ReflectionMethod($instance, $action);

        $dependencies = [];

        foreach ($reflectionMethod->getParameters() as $parameter) {

            $type = $parameter->getType();

            // Class dependency
            if ($type && !$type->isBuiltin()) {

                $dependencies[] = $container->make($type->getName());
                continue;
            }

            // Route parameter
            $name = $parameter->getName();

            if (isset($route->parameters[$name])) {
                $dependencies[] = $route->parameters[$name];
                continue;
            }

            // Default value
            if ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
                continue;
            }

            throw new \Exception("Unable to resolve parameter '{$name}'");
        }

        $reflectionMethod->invokeArgs($instance, $dependencies);
    }

    private function findRoute(string $method, string $uri): ?Route
    {
        if (!isset($this->routes[$method])) {
            return null;
        }

        foreach ($this->routes[$method] as $route) {

            // Exact match
            if ($route->uri === $uri) {
                return $route;
            }
            $routeParts = explode('/', trim($route->uri, '/'));
            $uriParts = explode('/', trim($uri, '/'));

            // Number of segments must match
            if (count($routeParts) !== count($uriParts)) {
                continue;
            }
            $parameters = [];
            $matched = true;
            
            // Segment matching loop
            foreach ($routeParts as $index => $part) {
                // Dynamic parameter
                if (preg_match('/^\{(.+)\}$/', $part, $matches)) {
                    $parameters[$matches[1]] = $uriParts[$index];
                    continue;
                }

                // Static segment must match
                if ($part !== $uriParts[$index]) {
                    $matched = false;
                    break;
                }

            }

            // Return immediately if this route matched (FIXED LOCATION)
            if ($matched) {
                $route->parameters = $parameters;

                return $route;
            }
        }

        return null;
    }
}