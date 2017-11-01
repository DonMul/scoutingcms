<?php

namespace Controller\Admin\User;

use Controller\Admin;
use Lib\Data\User;

/**
 * Class Overview
 * @package Controller\Admin\User
 */
class Overview extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('user.edit');

        return [
            'users' => User::getAll(),
            'active' => 'user'
        ];
    }
}