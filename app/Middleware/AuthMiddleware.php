<?php
/**
 * $router->get('/dashboard', [DashboardController::class, 'index'])
 *      ->middleware(AuthMiddleware::class);
 */

/**
 * AuthMiddleware
 * 
 * Browser
 *     ↓
 * Router
 *     ↓
 * Route Object
 *     ↓
 * AuthMiddleware
 *     ↓
 * DashboardController
 */

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Response;
use App\Core\Session;

class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private Session $session,
        private Response $response
    ) {
    }

    public function handle(): void
    {
        if (!$this->session->has('user_id')) {
            $this->response->redirect('/login');
        }
    }
}