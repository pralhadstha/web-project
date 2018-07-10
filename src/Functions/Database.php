<?php

namespace App\Functions;

use App\Helpers\ConfigHelper;
use PDO;
use PDOException;

/**
 * Class Database
 * @package App\Controllers
 */
class Database
{
    /**
     * @var mixed
     */
    protected $database;

    /**
     * @var
     */
    protected $connection;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->database = include(ConfigHelper::config('database.php'));
        $this->init();
    }

    /**
     * Initialize the database connection for the operations.
     */
    public function init()
    {
        $dbType = $this->database['default'];
        $dbDetails = $this->database['connection'][$dbType];
        try {
            $this->connection = new PDO("mysql:host={$dbDetails['host']};dbname={$dbDetails['database']}", $dbDetails['username'], $dbDetails['password']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * @param $query
     * @return mixed
     */
    public function exec($query)
    {
        if (!$this->connection) {
            $this->init();
        }

        return $this->connection->exec($query);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function fetchAll($query)
    {
        return $query->fetchAll();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function query($query)
    {
        if (!$this->connection) {
            $this->init();
        }

        return $this->connection->query($query);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function prepare($query)
    {
        if (!$this->connection) {
            $this->init();
        }

        return $this->connection->prepare($query);
    }

    /**
     * @return null
     */
    public function close()
    {
        return $this->connection = null;
    }
}
