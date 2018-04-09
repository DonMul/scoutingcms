<?php

namespace Lib\Core\ExceptionHandler;

use Lib\Exception\UserException;

/**
 * Class Mailer
 * @package Lib\Core\ExceptionHandler
 * @author Joost Mul <joost@jmul.net>
 */
final class Mailer implements IExceptionHandler
{
    const NAME = 'mail';

    /**
     * @var string
     */
    private $address;

    /**
     * Mailer constructor.
     * @param string $address
     */
    public function __construct(string $address)
    {
        $this->address = $address;
    }

    /**
     * @param \Throwable $ex
     */
    public function handleException(\Throwable $ex)
    {
        if ($ex instanceof UserException) {
            return;
        }

        $exceptionString = print_r($ex, true);

        if (isset($_SERVER) && count($_SERVER) > 0) {
            $exceptionString .= '$_SERVER = ' . print_r($_SERVER, true);
        }
        if (isset($_GET) && count($_GET) > 0) {
            $exceptionString .= '$_GET = ' . print_r($_GET, true);
        }
        if (isset($_POST) && count($_POST) > 0) {
            $exceptionString .= '$_POST = ' . print_r($_POST, true);
        }
        if (isset($_SESSION) && count($_SESSION) > 0) {
            $exceptionString .= '$_SESSION = ' . print_r($_SESSION, true);
        }
        if (isset($_COOKIE) && count($_COOKIE) > 0) {
            $exceptionString .= '$_COOKIE = ' . print_r($_COOKIE, true);
        }
        if (isset($argv) && count($argv) > 0) {
            $exceptionString .= '$argv = ' . print_r($argv, true);
        }

        mail($this->address, "Exception: " . $exceptionString, print_r($ex->getTrace(), true));
    }
}
