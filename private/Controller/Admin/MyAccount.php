<?php

namespace Controller\Admin;

use Controller\Admin;
use Lib\Core\Session;
use Lib\Data\User;

/**
 * Class MyAccount
 * @package Controller\Admin
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class MyAccount extends Admin
{
    public function getArray()
    {
        $user = User::getById(Session::getInstance()->getKey());

        return [
            'user' => $user,
            'roles' => $user->getRoles(),
        ];
    }
}
