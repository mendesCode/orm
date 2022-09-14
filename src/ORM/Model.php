<?php

namespace App\ORM;

use App\Helpers\Str;

abstract class Model
{
    /** @var string The database table associated with the model  */
    protected string $table;

    /** @var array An associative array containing the columns and values of a database record */
    protected array $attributes = [];

    protected array $fillable = [];

    protected array $guarded = ['*'];

    /** @var array A list with all the modified and not persisted attributes */
    protected array $dirty = [];

    /** @var Query A query builder object that will run the queries associated with this model */
    protected static Query $queryBuilder;

    public function __construct(array $attributes = [])
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

    /**
     * Get the list of attributes marked as dirty
     *
     * @return array
     */
    public function dirty(): array
    {
        return $this->dirty;
    }

    /**
     * Set one or more attributes as dirty
     *
     * @param string|string[] $attributes
     * @return $this
     */
    public function setDirty($attributes): self
    {
        if (!$attributes) {
            return $this;
        }

        if (!is_array($attributes)) {
            $attributes = [$attributes];
        }

        $attributes = array_filter($attributes, function ($field) {
            return in_array($field, array_keys($this->attributes));
        });

        foreach ($attributes as $attribute) {
            if (in_array($attribute, $this->dirty)) {
                continue;
            }

            $this->dirty[] = $attribute;
        }

        return $this;
    }

    /**
     * Checks if one or more attributes are marked as dirty, if at least one is dirty, returns true
     *
     * @param string|string[] $attributes The value or values to be checked
     * @return bool
     */
    public function isDirty($attributes = null): bool
    {
        if (empty($attributes)) {
            return count($this->dirty) > 0;
        }

        if (!is_array($attributes)) {
            $attributes = [$attributes];
        }

        foreach ($attributes as $attribute) {
            if (in_array($attribute, $this->dirty)) {
                return true;
            }
        }

        return false;
    }

    public function fill(array $attributes, array $options = []): self
    {
        if (empty($this->fillable) && $this->guarded == ['*']) {
            return $this;
        }

        $fillable = array_keys($attributes);

        if (!empty($this->fillable)) {
            $fillable = $this->fillable;
        }

        if (!empty($this->guarded) && $this->guarded != ['*']) {
            $fillable = array_diff($fillable, $this->guarded);
        }

        foreach ($attributes as $key => $value) {
            if (!in_array($key, $fillable)) {
                continue;
            }

            $this->set($key, $value);
        }

        return $this;
    }

    public static function all($select = ['*'], array $options = []): ?array
    {
        return null;
    }

    public function get(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function set(string $name, $value): self
    {
        $this->attributes[$name] = $value;
        $this->setDirty($name);

        return $this;
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }
}
