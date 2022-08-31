<?php

namespace App;

use Dotenv\Dotenv;

class Config
{
    protected static bool $loaded = false;
    private static array $data;

    public static function load(string $path = null)
    {
        if (!$path) {
            $path = dirname(__DIR__);
        }

        try {
            static::$data = Dotenv::createImmutable($path)->load();
        } catch (\Exception $e) {
            throw new \Exception('Missing .env file');
        }

        static::$loaded = true;

        return true;
    }

    public static function read(string $field)
    {
        if (!static::$loaded) {
            static::load();
        }

        return static::$data[$field] ?? null;
    }

    public static function write(string $field, $value)
    {
        if (!static::$loaded) {
            static::load();
        }

        static::$data[$field] = $value;
    }
}
