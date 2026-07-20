<?php

declare(strict_types=1);

namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);

        $viewFile = dirname(__DIR__) . "/Views/{$view}.php";

        if (!file_exists($viewFile)) {
            throw new \Exception("View {$view} not found.");
        }

        require $viewFile;
    }
}