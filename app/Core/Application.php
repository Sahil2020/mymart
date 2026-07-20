<?php

declare(strict_types=1);

namespace App\Core;

use App\Controllers\HomeController;

class Application
{
    public function run(): void
    {
        // $controller = new HomeController();

        // $controller->index();

        $router = new Router();

        require dirname(__DIR__, 2) . '/routes/web.php';

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $basePath = '/public';
        // $basePath = '/mymart/public';

        if (str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }
        $uri = $uri ?: '/';

        $router->dispatch($uri);
    }
}