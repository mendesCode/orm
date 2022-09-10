<?php

namespace App\ORM;

use Exception;

class Query
{
    private Model $model;

    public function __construct(Model $model)
    {
        $this->setModel($model);
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Perform an SELECT query on the model associated with the instance
     *
     * @param array $columns
     * @param array $options
     * @return array
     * @throws Exception
     */
    public function select(array $columns = ['*'], array $options = []): array
    {
        $connection = Connection::getInstance();

        if (empty($columns)) {
            $columns = ['*'];
        }

        $query = 'SELECT (';
    }
}
