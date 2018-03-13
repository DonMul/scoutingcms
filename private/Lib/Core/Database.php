<?php

namespace Lib\Core;

/**
 * Class Database
 * @package Lib\Core
 * @author Joost Mul <scoutingcms@jmul.net>
 */
class Database extends \Lib\Core\Singleton
{
    /**
     * @var string
     */
    private $prefix;

    /**
     * THe underlying MySQL database connection
     *
     * @var \mysqli
     */
    private $connection;

    /**
     * Whether or not the connection should have been initiated
     * @var bool
     */
    private $connectionLoaded = false;

    /**
     * @param string $tableName
     * @return string
     */
    public function getFullTableName($tableName)
    {
        $this->ensureConnection();
        return $this->prefix . $tableName;
    }

    /**
     * Executes the given query and returns the mysql_result of it. Bind the given params to the query's
     * prepared statement
     *
     * @param  string $query
     * @param  array  $params
     * @param  string $types
     * @return \mysqli_stmt
     * @throws \Exception
     */
    public function query($query, $params = [], $types = '')
    {
        if (count($params) !== strlen($types)) {
            throw new \Exception("MySQL Error: Given parameter amount does not match the types");
        }

        $this->ensureConnection();

        $stmt = $this->connection->prepare($query);
        if (!empty($params)) {
            $args = [];
            array_unshift($params, $types);
            $count = count($params);

            for ($i = 0; $i < $count; $i++) {
                $args[$i] = & $params[$i];
            }

            call_user_func_array([$stmt, 'bind_param'], $args);
        }

        if (!$stmt) {
            throw new \Exception($this->connection->error);
        }

        $stmt->execute();

        if (!$stmt) {
            throw new \Exception($stmt->error, $stmt->errno);
        }

        return $stmt;
    }

    /**
     * @param string $queries
     * @return bool
     */
    public function multiQuery($queries)
    {
        return $this->connection->multi_query($queries);
    }

    /**
     * Returns the first row of the given query's result set.
     *
     * @param string $query
     * @param array  $params
     * @param string $types
     * @return mixed
     */
    public function fetchOne($query, $params = [], $types = '')
    {
        $result = $this->query($query, $params, $types);
        $result = $result->get_result();
        $return = null;

        while ($row = $result->fetch_assoc()) {
            $return = $row;
            break;
        }

        return $return;
    }

    /**
     * Change the database connection to make use of another database with the given name
     *
     * @param string $databaseName
     */
    public function changeDb($databaseName)
    {
        $this->ensureConnection();
        $this->connection->select_db($databaseName);
    }

    /**
     * Executes the query and returns its result set as an array with associative arrays
     *
     * @param string $query
     * @param array  $params
     * @param string $types
     * @return mixed
     */
    public function fetchAll($query, $params = [], $types = '')
    {
        $result = $this->query($query, $params, $types);
        $result = $result->get_result();
        $return = [];
        while ($row = $result->fetch_assoc()) {
            $return[] = $row;
        }

        return $return;
    }

    /**
     * @return int
     */
    public function lastInsertId()
    {
        return mysqli_insert_id($this->connection);
    }

    /**
     * Makes sure the connection is made with the database.
     *
     * @throws \Exception
     */
    protected function ensureConnection()
    {
        if (!$this->connectionLoaded) {
            $dbSettings = \Lib\Core\Settings::getInstance()->get('database', []);
            $this->connection = @mysqli_connect($dbSettings['host'], $dbSettings['username'], $dbSettings['password'], $dbSettings['database']);


            if (!$this->connection) {
                throw new \Exception("MySql connect error: " . mysqli_connect_error());
            }

            $this->prefix = Util::arrayGet($dbSettings, 'prefix', '');
            $this->connectionLoaded = true;
        }
    }
}
