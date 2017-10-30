<?php

namespace Controller\Admin\User;

use Controller\Admin;
use Lib\Data\Role;

/**
 * Class User
 * @package Controller\Admin\User
 */
class User extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $user = \Lib\Data\User::getById($_GET['id']);
        if (!$user) {
            $user = new \Lib\Data\User(
                null,
                '',
                '',
                '',
                ''
            );
        }

        return [
            'user' => $user,
            'roles' => Role::getAll(),
            'userRoles' => $user->getRoles(),
        ];
    }
}