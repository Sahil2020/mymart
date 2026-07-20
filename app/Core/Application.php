<?php

declare(strict_types=1);

namespace App\Core;

class Application
{
    public function run(): void
    {
        $home = new Home();

        $home->index();
    }
}