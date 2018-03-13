<?php

namespace Lib\Core;

/**
 * Class Singleton
 * @package Lib\Core
 * @author Joost Mul <scoutingcms@jmul.net>
 */
class Singleton
{
    /**
     * A collection of all instances generated with the singleton class
     *
     * @var Singleton[]
     */
    protected static $instances = [];

    /**
     * Gets the singleton instance of the called class
     *
     * @return static
     */
    public static function getInstance()
    {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class;
        }

        return self::$instances[$class];
    }
}
