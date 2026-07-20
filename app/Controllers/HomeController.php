<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\HomeService;

class HomeController extends Controller
{
    private HomeService $service;

    public function __construct()
    {
        $this->service = new HomeService();
    }

    public function index(): void
    {
        $this->view('home', [

            'title' => config('app.name'),

            'version' => $this->service->getDatabaseVersion(),

            'developer' => 'Sahil'

        ]);
    }
}