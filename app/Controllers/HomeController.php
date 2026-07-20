<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home', [

            'title' => 'MyMart',

            'version' => '1.0.0',

            'developer' => 'Sahil'

        ]);
    }
}