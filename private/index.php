<?php

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header('Location: https://scoutingflg.jmul.net');
}
session_start();
require_once dirname(__FILE__) . '/bootstrap.php';

try {
    $a = new \Lib\Core\Application();
    $a->initiate();
} catch (\Exception $ex) {
    $exceptionHandler = \Lib\Core\ExceptionHandler::getInstance();
    $exceptionHandler->handle($ex);
}
