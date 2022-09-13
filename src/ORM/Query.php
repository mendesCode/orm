<?php

namespace App\ORM;

require_once __DIR__ . '/../../vendor/autoload.php';

use PDO;

class Query
{
    /** @var PDO The database connection instance */
    private PDO $pdo;

    /** @var Model The model being queried */
    private Model $model;

    /** @var string The database table to be used on queries */
    private string $from;

    public function __construct(Model $model)
    {
        $this->setModel($model);

        $this->from = $this->getModel()->getTable();
        $this->pdo = Connection::getInstance();
    }

    /**
     * Get the model being queried
     *
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Set the model being queried
     *
     * @param Model $model
     * @return $this
     */
    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the database table and optionally an alias to be used on a query
     *
     * @param string|null $alias
     * @return string
     */
    public function getFrom(string $alias = null): string
    {
        return $alias ? "{$this->from} as {$alias}" : $this->from;
    }

    /**
     * Set the database table to be used on the queries
     *
     * @param string $from
     * @return $this
     */
    public function setFrom(string $from): self
    {
        $this->from = $from;

        return $this;
    }

    public function select($columns = ['*'], array $options = []): array
    {
        if (empty($columns)) {
            $columns = ['*'];
        }

        $stmt = $this->pdo->prepare('SELECT * FROM planet');
    }
}
