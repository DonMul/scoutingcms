<?php

namespace Lib\Repository;

use Lib\Core\Database;

/**
 * Class BaseRepository
 * @package Lib\Repository
 */
abstract class BaseRepository
{
    /**
     * @var Database
     */
    private $database;

    /**
     * @param Database $database
     */
    public function setDatabase(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @return Database
     */
    protected function getDatabase()
    {
        if (!($this->database instanceof Database)) {
            $this->setDatabase(Database::getInstance());
        }

        return $this->database;
    }
}
