<?php

namespace Lib\Core;

/**
 * Class ExceptionHandler
 * @package Lib\Core
 * @author Joost Mul <jmul@posd.io>
 */
class ExceptionHandler extends \Lib\Core\Singleton
{
    /**
     * @param \Exception $ex
     */
    public function handle(\Exception $ex)
    {
        print_r($ex);
    }
}
