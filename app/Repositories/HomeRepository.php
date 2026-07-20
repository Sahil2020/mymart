<?php

declare(strict_types=1);

namespace App\Repositories;

class HomeRepository extends BaseRepository
{
    public function getDatabaseVersion(): string
    {
        return $this->db->getAttribute(\PDO::ATTR_SERVER_VERSION);
    }
}