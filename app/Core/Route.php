<?php

declare(strict_types=1);

namespace App\Core;

class Route
{
    public array $middlewares = [];

    public function __construct(
        public string $uri,
        public string $method,
        public array $action
    ) {
    }

    public function middleware(string $middleware): self
    {
        $this->middlewares[] = $middleware;

        return $this;
    }
}