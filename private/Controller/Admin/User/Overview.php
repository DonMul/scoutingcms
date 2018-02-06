<?php

namespace Controller\Admin\User;

use Controller\Admin;

/**
 * Class Overview
 * @package Controller\Admin\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Overview extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('user.edit');

        return [
            'users' => $this->getUserRepository()->getAll(),
            'active' => 'user'
        ];
    }
}
