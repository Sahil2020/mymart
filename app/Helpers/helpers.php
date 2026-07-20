<?php

declare(strict_types=1);

if (!function_exists('env')) {

    function env(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists('config')) {

    function config(string $key, mixed $default = null): mixed
    {
        return \App\Core\Config::get($key, $default);
    }
}

if (!function_exists('dd')) {

    function dd(mixed $value): void
    {
        echo '<pre style="background-color: #f4f4f4; padding: 10px; border: 1px solid #ccc;">';
        print_r($value);
        echo '</pre>';
        exit;
    }
}