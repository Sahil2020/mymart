<?php

declare(strict_types=1);

namespace App\Controllers;

class HomeController
{
    public function index(): void
    {
        echo "<h1>Welcome to MyMart</h1>";
    }
}