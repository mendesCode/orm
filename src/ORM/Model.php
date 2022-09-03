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

    public function getTable(): string
    {
        if (!empty($this->table)) {
            return $this->table;
        }

        $model = substr(static::class, (strrpos(static::class, '\\') + 1));

        return Str::tableize($model);
    }

    public function setTable(string $table): self
    {
        $this->table = $table;

        return $this;
    }
}
