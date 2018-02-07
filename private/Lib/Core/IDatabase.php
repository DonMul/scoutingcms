<?php

namespace Lib\Core;

/**
 * Interface IDatabase
 * @package Lib\Core
 * @author Joost Mul <scoutingcms@jmul.net>
 */
interface IDatabase
{
    /**
     * Returns the first row of the given query's result set.
     *
     * @param string $query
     * @param array  $params
     * @param string $types
     * @return mixed
     */
    public function fetchOne($query, $params = [], $types = '');

    /**
     * Executes the query and returns its result set as an array with associative arrays
     *
     * @param string $query
     * @param array  $params
     * @param string $types
     * @return mixed
     */
    public function fetchAll($query, $params = [], $types = '');
}
