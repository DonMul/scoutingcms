<?php

session_start();
require_once dirname(__FILE__) . '/bootstrap.php';

if (\Lib\Core\Settings::getInstance()->get('ssl', false) == true &&
    (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on')
) {
    header('Location: https://' . $_SERVER['HTTP_HOST']);
}

try {
    $a = new \Lib\Core\Application();
    $a->initiate();
} catch (\Exception $ex) {
    $exceptionHandler = \Lib\Core\ExceptionHandler::getInstance();
    $exceptionHandler->handle($ex);
}
