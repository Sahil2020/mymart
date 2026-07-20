<?php

declare(strict_types=1);

namespace App\Core;

class Response
{
    public function view(string $view, array $data = []): void
    {
        extract($data);

        $viewPath = APP_PATH . '/Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("View '{$view}' not found.");
        }

        require $viewPath;
    }

    public function json(array $data, int $status = 200): void
    {
        http_response_code($status);

        header('Content-Type: application/json');

        echo json_encode($data);

        exit;
    }

    public function redirect(string $url): void
    {
        header("Location: {$url}");

        exit;
    }
}