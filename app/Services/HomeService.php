<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\HomeRepository;

class HomeService
{
    private HomeRepository $repository;

    public function __construct()
    {
        $this->repository = new HomeRepository();
    }

    public function getDatabaseVersion(): string
    {
        return $this->repository->getDatabaseVersion();
    }
}