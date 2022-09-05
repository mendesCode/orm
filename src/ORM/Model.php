<?php

namespace App\ORM;

use App\Helpers\Str;

abstract class Model
{
    /** @var string The database table associated with the model  */
    protected string $table;

    public function __construct()
    {
        if (!isset($this->table)) {
            $this->table = $this->getTable();
        }
    }

    /**
     * Get the table associated with the model
     *
     * @return string
     */
    public function getTable(): string
    {
        if (isset($this->table)) {
            return $this->table;
        }

        $model = substr(static::class, (strrpos(static::class, '\\') + 1));

        return Str::tableize($model);
    }

    /**
     * Set the table associated with the model
     *
     * @param string $table
     * @return $this
     */
    public function setTable(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    public static function all($select = '*', $options = []): ?array
    {
        $query = 'SELECT (';

        return null;
    }
}
