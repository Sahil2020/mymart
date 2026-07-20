<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];
    
    public function get(string $uri, array $action): void
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function dispatch(string $uri): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            exit('404 Page Not Found');
        }

        [$controller, $function] = $this->routes[$method][$uri];

        $controller = new $controller();

        $controller->$function();
    }
}
