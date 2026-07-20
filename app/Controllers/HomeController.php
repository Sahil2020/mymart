<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Services\HomeService;
use App\Core\Response;


class HomeController extends Controller
{
    public function __construct(
        private HomeService $service,
        private Response $response
    ) {
    }

    public function index(Request $request)
    {
        // return $this->response->json([
        //     'status' => 'success',
        //     'message' => 'Welcome to MyMart'
        // ]);
        $this->response->view('home', [

            'title' => config('app.name'),

            'version' => $this->service->getDatabaseVersion(),

            'developer' => 'Sahil',
            
            'method' => $request->method(),

            'uri' => $request->uri(),

        ]);
    }
}