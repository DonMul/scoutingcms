<?php

namespace Controller\User;

use Lib\Core\BaseController;
use Lib\Core\Session;

/**
 * Class Logout
 * @package Controller\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Logout extends BaseController
{
    /**
     *
     */
    public function getArray()
    {
        Session::getInstance()->logOut();

        if (!headers_sent()) {
            header('Location: /');
        }
    }
}
