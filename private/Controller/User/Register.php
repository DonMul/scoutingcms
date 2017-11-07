<?php

namespace Controller\User;

use Lib\Core\BaseController;
use Lib\Core\Session;

/**
 * Class Register
 * @package Controller\User
 */
class Register extends BaseController
{
    /**
     *
     */
    public function getArray()
    {
        if (Session::getInstance()->isLoggedIn()) {
            //header("Location: /");
        }
    }
}