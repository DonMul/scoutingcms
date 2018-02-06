<?php

namespace Controller\Admin\User;

use Controller\Admin;

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

        $user = $this->getUserRepository()->getById($this->getVariable('id', 0));
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
            'roles' => $this->getRoleRepository()->getAll(),
            'userRoles' => $this->getUserRepository()->getRoles($user),
            'active' => 'user'
        ];
    }
}
