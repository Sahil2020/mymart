<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/app/Core/Autoloader.php';

require_once dirname(__DIR__) . '/app/Helpers/helpers.php';

use App\Core\Application;
use App\Core\Autoloader;
use App\Core\Env;
use App\Core\Config;

Autoloader::register();

Env::load(dirname(__DIR__) . '/.env');

Config::load();

$app = new Application();

$app->run();