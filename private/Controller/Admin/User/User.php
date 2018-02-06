<?php

namespace Controller\Admin\User;

use Controller\Admin;
use Lib\Data\Role;

/**
 * Class User
 * @package Controller\Admin\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class User extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('user.edit');

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
            'active' => 'user'
        ];
    }
}
