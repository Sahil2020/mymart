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

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            require APP_PATH . '/Views/errors/404.php';
            exit;
        }

        /** @var Route $route */
        $route = $this->routes[$method][$uri];

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

            if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                $dependencies[] = $container->make($type->getName());
            }

        }

        $reflectionMethod->invokeArgs($instance, $dependencies);
    }
}