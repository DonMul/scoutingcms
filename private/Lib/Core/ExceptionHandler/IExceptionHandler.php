<?php

namespace Lib\Core\ExceptionHandler;

/**
 * Interface IExceptionHandler
 * @package Lib\Core\ExceptionHandler
 * @author Joost Mul <joost@jmul.net>
 */
interface IExceptionHandler
{
    /**
     * @param \Throwable $ex
     */
    public function handleException(\Throwable $ex);
}
