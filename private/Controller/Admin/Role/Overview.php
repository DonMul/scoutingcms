<?php
namespace Controller\Admin\Role;

use Controller\Admin;
use Lib\Data\Role;

/**
 * Class Overview
 * @package Controller\Admin\Role
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Overview extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('role.edit');

        return [
            'roles' => Role::getAll(),
            'active' => 'role'
        ];
    }
}
