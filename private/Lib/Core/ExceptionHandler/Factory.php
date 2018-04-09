<?php

namespace Lib\Core\ExceptionHandler;
use Lib\Core\Settings;
use Lib\Core\Util;

/**
 * Class Factory
 * @package Lib\Core\ExceptionHandler
 * @author Joost Mul <joost@jmul.net>
 */
final class Factory
{
    /**
     * @var IExceptionHandler
     */
    private static $instance;

    /**
     * @return IExceptionHandler
     */
    public static function getExceptionHandler(): IExceptionHandler
    {
        if (self::$instance instanceof IExceptionHandler) {
            return self::$instance;
        }

        $settings = Settings::getInstance()->get(['exceptions']);
        switch (Util::arrayGet($settings, 'handler')) {
            case Mailer::NAME:
            default:
                self::$instance = new Mailer(
                    Util::arrayGet($settings, 'address', '')
                );
                break;
        }

        return self::$instance;
    }
}
