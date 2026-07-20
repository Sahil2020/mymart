<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/app/Core/Autoloader.php';

require_once dirname(__DIR__) . '/app/Helpers/helpers.php';

use App\Core\Application;
use App\Core\Autoloader;
use App\Core\Env;
use App\Core\Config;

//define constants
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');
define('STORAGE_PATH', BASE_PATH . '/storage');
define('PUBLIC_PATH', __DIR__);

Autoloader::register();

Env::load(dirname(__DIR__) . '/.env');

Config::load();

$app = new Application();

$app->run();