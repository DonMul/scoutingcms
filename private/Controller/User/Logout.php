<?php

namespace Controller\User;

use Lib\Core\BaseController;
use Lib\Core\Session;

/**
 * Class Logout
 * @package Controller\User
 */
class Logout extends BaseController
{
    /**
     *
     */
    public function getArray()
    {
        Session::getInstance()->logOut();
        header('Location: /');
    }
}