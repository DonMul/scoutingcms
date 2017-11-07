<?php

require_once realpath(dirname(__FILE__) . '/../../private/bootstrap.php');

$settings = \Lib\Core\Settings::getInstance();
try {
    $parser = new Less_Parser();
    $parser->parseFile(__DIR__ . '/main.less', ($settings->get('ssl') ? 'https://' : 'http://') .$_SERVER['HTTP_HOST'] . '/css/');
    header("Content-type: text/css");
    echo $parser->getCss(); exit;
} catch (\Exception $ex) {
    var_dump($ex->getMessage());
}