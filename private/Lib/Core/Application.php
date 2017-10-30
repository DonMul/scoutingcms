<?php

namespace Lib\Core;

/**
 * Class Application
 * @package Lib\Core
 * @author  Joost Mul <jmul@posd.io>
 */
class Application extends \Lib\Core\Singleton
{
    /**
     * @var string
     */
    private $requestUrl;

    /**
     *
     */
    public function __construct()
    {
        $this->requestUrl = '/' . ltrim($_GET['_url'], '/');
        unset($_GET['_url']);
    }

    /**
     *
     */
    public function initiate()
    {
        \Lib\Core\Dispatcher::getInstance()->dispatchUrl($this->requestUrl);
    }
} 
