<?php

namespace App\ORM;

use PDO;

class Connection
{
    private static $connection;

    public static function getInstance(): ?PDO
    {
        if (isset(static::$connection) && (static::$connection instanceof PDO)) {
            return static::$connection;
        }

        try {
            static::$connection = new PDO("");
        } catch (\PDOException $e) {
            return null;
        }

        return static::$connection;
    }

    protected function __construct()
    {}

    private function __clone()
    {}
}
