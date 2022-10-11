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

    private array $whereOperators = [
        '=',
        '<',
        '>',
        '<=',
        '>=',
        '<>',
        '!=',
        'IS',
        'IS NOT',
        'IS NULL',
        'IS NOT NULL',
        'BETWEEN',
        'NOT BETWEEN',
        'LIKE',
        'NOT LIKE',
        'ILIKE',
        'NOT ILIKE',
        'IN',
        'NOT IN'
    ];

    /** @var string The raw query to be prepared by PDO */
    private string $rawQuery;

    /** @var array The placeholder replacements for the prepared query */
    private array $params = [];

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

    protected function getWhere(array $conditions): string
    {
        if (empty($conditions)) {
            return '';
        }

        $whereClause = '';

        foreach ($conditions as $key => $value) {
            $expression = is_int($key) ? $value : $key;

            // Check if the expression string is composed of an "operand + operator" and then validates the operator
            if (!preg_match('/([A-Za-z0-9_.]+)\s?(.*)/', $expression, $matches)) {
                continue;
            }

            $operand = $matches[1];
            $operator = !empty($matches[2]) ? $matches[2] : '=';

            if (!in_array($operator, $this->whereOperators)) {
                continue;
            }

            if ($whereClause) {
                $whereClause .= ' AND ';
            }

            if (is_int($key)) {
                $whereClause .= "{$operand} {$operator}";
                continue;
            }

            $this->params[] = $value;
            $whereClause .= "{$operand} {$operator} :" . (count($this->params) - 1);
        }

        return " WHERE {$whereClause}";
    }

    public function select($columns = ['*'], array $options = []): array
    {
        if (empty($columns)) {
            $columns = ['*'];
        }

        $query = 'SELECT ';
        $query .= implode(', ', $columns) . ' FROM ' . $this->from;

        if (!empty($options['where'])) {
            $query .= $this->getWhere($options['where']);
        }

        echo $query;

        return [];
    }
}
