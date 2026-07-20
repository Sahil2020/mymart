<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\HomeRepository;

class HomeService
{
    public function __construct(
        private HomeRepository $repository
    ) {
    }

    public function getDatabaseVersion(): string
    {
        return $this->repository->getDatabaseVersion();
    }
}