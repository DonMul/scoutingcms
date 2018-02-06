<?php

namespace Controller\User;

use Lib\Core\BaseController;
use Lib\Core\Session;

/**
 * Class Register
 * @package Controller\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Register extends BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        if (Session::getInstance()->isLoggedIn()) {
            header("Location: /");
        }

        return [];
    }
}
