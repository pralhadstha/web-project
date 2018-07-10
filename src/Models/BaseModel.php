<?php

namespace App\Models;

use App\Functions\Database;
use PDO;

/**
 * Class BaseModel
 * @package App\Models
 */
class BaseModel
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var object
     */
    protected $connection;

    /**
     * BaseModel constructor.
     */
    public function __construct()
    {
        $this->connection = new Database();
    }

    /**
     * @param array $property
     * @return mixed
     */
    public function create($property = [])
    {
        $columnValueArray = $this->columnValuePair($property);
        $query = $this->insertQuery($columnValueArray['column'], $columnValueArray['attributes']);
        return $this->executeQuery($query);
    }

    /**
     * @param $parameters
     * @param $clause
     * @return mixed
     */
    public function update($parameters, $clause)
    {
        $columnValueArray = $this->columnValuePair($parameters, false);
        $query = $this->updateQuery($columnValueArray['attributes'], $clause);
        return $this->executeQuery($query);
    }

    /**
     * @param $column
     * @param $operator
     * @param $value
     * @param bool $single
     * @param null $clause
     * @return mixed
     */
    public function deleteWhere($column, $operator, $value , $single = false, $clause = null)
    {
        $query = $this->deleteQuery($column, "'".$value."'", $operator, $single, $clause);
        return $this->executeQuery($query);
    }

    /**
     * @param $clause
     * @param null $columns
     * @return mixed
     */
    public function selectWhere($clause, $columns = null)
    {
        if (!$columns) {
            $columns = $this->getColumns();
        }
        array_unshift($columns, "{$this->primaryKey}");
        $columns = $this->getColumn($columns);
        $query = $this->selectQuery($columns, $clause);
        return $this->fetchAll($query);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function executeQuery($query)
    {
        return $this->prepare($query)->execute();
    }

    /**
     * @param $preparedQuery
     * @return mixed
     */
    public function execute($preparedQuery)
    {
        return $preparedQuery->execute();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function prepare($query)
    {
        return $this->connection->prepare($query);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function fetchAll($query)
    {
        $result = $this->prepare($query);
        $this->execute($result);
        return $result->fetchAll();
    }

    /**
     * @param null $columns
     * @return string
     */
    public function getColumn($columns = null)
    {
        if (!$columns) {
            $columns = $this->columns;
        }
        return $this->separateValueGenerator($columns, ',');
    }

    /**
     * @param $attributes
     * @param bool $addQuote
     * @return string
     */
    public function getAttribute($attributes, $addQuote = true)
    {
        $sortedArray = $this->sortArray($attributes);
        if ($addQuote) {
            return "'" . $this->separateValueGenerator($sortedArray) . "'";
        }
        return $this->separateValueGenerator($sortedArray, ',');
    }

    /**
     * @param $dataArray
     * @return array
     */
    protected function sortArray($dataArray)
    {
        $returnArray = [];
        foreach ($dataArray as $key => $value) {
            $returnArray[$key] = $dataArray[$key];
        }
        return $returnArray;
    }

    /**
     * @param $array
     * @param string $separator
     * @return string
     */
    protected function separateValueGenerator($array, $separator = "','")
    {
        return implode($separator, $array);
    }

    /**
     * @param $attributes
     * @param bool $addQuote
     * @return array|bool
     */
    public function columnValuePair($attributes, $addQuote = true)
    {
        $query = null;
        $column = $this->getColumn();
        if (empty(array_filter($attributes))) {
            return false;
        }
        $attributes = $this->getAttribute($attributes, $addQuote);

        return [
            'column' => $column,
            'attributes' => $attributes
        ];
    }

    /**
     * @param $column
     * @param $attributes
     * @return string
     */
    protected function insertQuery($column, $attributes)
    {
        return "INSERT INTO {$this->table} ({$column}) VALUES ({$attributes})";
    }

    /**
     * @param $column
     * @param $attributes
     * @return string
     */
    protected function selectQuery($column, $attributes)
    {
        return "SELECT {$column} FROM {$this->table} WHERE ({$attributes})";
    }

    /**
     * @param $column
     * @param $value
     * @param $operator
     * @param bool $single
     * @param null $clause
     * @return string
     */
    protected function deleteQuery($column, $value, $operator, $single = false, $clause = null)
    {
        $query =  "DELETE FROM {$this->table} WHERE ";
        if ($single) {
            return $query . "{$clause}";
        }
        return $query . "{$column} {$operator} {$value}";
    }

    /**
     * @param $columns
     * @param $clause
     * @return string
     */
    protected function updateQuery($columns, $clause)
    {
        return "UPDATE {$this->table} SET {$columns} WHERE {$clause}";
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param $result
     * @return mixed
     */
    public function first($result)
    {
        return $result[0];
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->selectWhere('1');
    }
}