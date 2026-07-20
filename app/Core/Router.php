<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $uri, array $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post(string $uri, array $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    private function addRoute(string $method, string $uri, array $action): void
    {
        $this->routes[$method][$uri] = $action;
    }

    public function dispatch(string $uri): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            require dirname(__DIR__) . '/Views/errors/404.php';
            exit;
        }

        [$controller, $action] = $this->routes[$method][$uri];

        // (new $controller())->$action();
        $container = new Container();

        $instance = $container->make($controller);

        // $instance->$action();
        $reflectionMethod = new \ReflectionMethod($instance, $action);
        $dependencies = [];
        foreach ($reflectionMethod->getParameters() as $parameter) {
            $type = $parameter->getType();

            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                $dependencies[] = $container->make($type->getName());
            }
        }
        $reflectionMethod->invokeArgs($instance, $dependencies);
    }
}