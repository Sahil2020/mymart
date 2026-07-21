<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Middleware\AuthMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

$router->get('/products/{id}', [HomeController::class, 'show']);

$router->get('/login', [HomeController::class, 'index']);

$router->get('/dashboard', [HomeController::class, 'index'])
       ->middleware(AuthMiddleware::class);
       
$router->get('/', [HomeController::class, 'index']);
