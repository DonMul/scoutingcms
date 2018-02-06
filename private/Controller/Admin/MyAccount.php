<?php

namespace Controller\Admin;

use Controller\Admin;
use Lib\Core\Session;

/**
 * Class MyAccount
 * @package Controller\Admin
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class MyAccount extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $user = $this->getUserRepository()->getById(Session::getInstance()->getKey());

        return [
            'user' => $user,
            'roles' => $this->getUserRepository()->getRoles($user),
        ];
    }
}
