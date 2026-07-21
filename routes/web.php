<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Middleware\AuthMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

$router->get('/dashboard', [HomeController::class, 'index'])
       ->middleware(AuthMiddleware::class);
       
$router->get('/', [HomeController::class, 'index']);
