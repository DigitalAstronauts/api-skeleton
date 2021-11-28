<?php
declare(strict_types=1);

namespace App;

class Env
{
    public static function get(string $key, $default)
    {
        return $_ENV[$key] ?? $default;
    }
}