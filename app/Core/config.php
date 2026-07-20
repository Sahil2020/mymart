<?php

declare(strict_types=1);

namespace App\Core;

class Config
{
    private static array $items = [];

    public static function load(): void
    {
        foreach (glob(dirname(__DIR__, 2) . '/config/*.php') as $file) {

            $key = basename($file, '.php');

            self::$items[$key] = require $file;
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $keys = explode('.', $key);

        $config = self::$items;

        foreach ($keys as $segment) {

            if (!isset($config[$segment])) {
                return $default;
            }

            $config = $config[$segment];
        }
        
        return $config;
    }
}