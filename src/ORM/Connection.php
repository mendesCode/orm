<?php

namespace App\ORM;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Config;
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
            /*
             * NOTE: The DSN format used by this project is specific for the PostgreSQL database driver
             * This project does not support MySQL/MariaDB connections yet
             */
            static::$connection = new PDO(static::getDSN());
        } catch (\PDOException $e) {
            return null;
        }

        return static::$connection;
    }

    private static function getDSN(): string
    {
        $prefix = 'pgsql:';

        $params = [
            'host' => Config::read('DB_HOST'),
            'port' => Config::read('DB_PORT'),
            'dbname' => Config::read('DB_DATABASE'),
            'user' => Config::read('DB_USER'),
            'password' => Config::read('DB_PASSWORD')
        ];
        $params = array_filter($params);

        foreach ($params as $key => $value) {
            $params[$key] = "{$key}={$value}";
        }

        return $prefix . implode(';', $params);
    }

    protected function __construct()
    {}

    private function __clone()
    {}
}
