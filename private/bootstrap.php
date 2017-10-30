<?php

define('ROOT', rtrim(dirname(__FILE__), '/') . '/');
define('LIBROOT', ROOT . 'Lib/');
define('CONFROOT', ROOT . 'Conf/');
define('TEMPLATEROOT', ROOT . 'twig/');

require_once LIBROOT . 'Core/Autoloader.php';
