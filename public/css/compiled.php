<?php

require_once realpath(dirname(__FILE__) . '/../../private/bootstrap.php');
header("Content-type: text/css; charset: UTF-8");

$settings = \Lib\Core\Settings::getInstance();
$compiledFile = dirname(__FILE__) . '/compiled.css';
if ($settings->get('dev') !== true) {
    if (file_exists($compiledFile)) {
        echo file_get_contents($compiledFile);
        exit;
    }
}

$parser = new Less_Parser();
$parser->parseFile(__DIR__ . '/main.less', ($settings->get('ssl') ? 'https://' : 'http://') .$_SERVER['HTTP_HOST'] . '/css/');
header("Content-type: text/css");
$css = $parser->getCss();

if (file_exists($compiledFile)) {
    unlink($compiledFile);
}

file_put_contents($compiledFile, $css);
echo $css;
exit;