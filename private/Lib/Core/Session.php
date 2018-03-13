<?php

namespace Lib\Core;

/**
 * Class Session
 * @package Lib\Core
 * @author Joost Mul <scoutingcms@jmul.net>
 */
class Session extends Singleton
{
    const SESSION_USER_KEY = '_user_id';
    const SESSION_COOKIE_NAME = 'SCMS_LOGIN';

    /**
     * @constructor
     */
    public function __construct()
    {
        if (isset($_COOKIE[self::SESSION_COOKIE_NAME]) && !isset($_SESSION[self::SESSION_USER_KEY])) {
            $_SESSION[self::SESSION_USER_KEY] = $_COOKIE[self::SESSION_COOKIE_NAME];
        }
    }

    /**
     * Returns whether or not the current visitor of the FrontEnd is logged in or not
     *
     * @return bool
     */
    public function isLoggedIn()
    {
        return isset($_SESSION[self::SESSION_USER_KEY]);
    }

    /**
     * Logs the user with the given key in.
     *
     * @param string $userKey
     */
    public function logIn($userKey)
    {
        $_SESSION[self::SESSION_USER_KEY] = $userKey;
        setcookie(self::SESSION_COOKIE_NAME, $userKey, time()+10800, '/', '.scoutingflg.nl');
    }

    /**
     * Logs the currently logged in user out
     */
    public function logOut()
    {
        unset($_SESSION[self::SESSION_USER_KEY]);
        if (!headers_sent()) {
            session_destroy();
            setcookie(self::SESSION_COOKIE_NAME, null, time()+10800, '/', '.scoutingflg.nl');
        }
    }

    /**
     * Returns the key of the current logged in user
     *
     * @return int
     */
    public function getKey()
    {
        return $this->isLoggedIn() ? $_SESSION[self::SESSION_USER_KEY] : null;
    }
}
