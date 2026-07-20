<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

class HomeRepository extends BaseRepository
{
    public function __construct(Database $database)
    {
        parent::__construct($database);
    }

    public function getDatabaseVersion(): string
    {
        return $this->db->getAttribute(PDO::ATTR_SERVER_VERSION);
    }
}