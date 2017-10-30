<?php

namespace Lib\Core;

require_once LIBROOT . 'Core/Singleton.php';

/**
 * Class Autoloader
 * @package Lib\Core
 * @author  Joost Mul <jmul@posd.io>
 */
class Autoloader extends Singleton
{
    /**
     * @param $class
     */
    public function load($class)
    {
        $fixedName = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $fixedName .= '.php';

        $fileLocations = [
            ROOT . $fixedName,
            LIBROOT . $fixedName,
        ];

        foreach ($fileLocations as $fileLocation) {
            if (file_exists($fileLocation)) {
                require_once $fileLocation;
            }
        }
    }
}

$autoLoader = \Lib\Core\Autoloader::getInstance();
spl_autoload_register([$autoLoader, 'load']);
