<?php

namespace Controller\Admin\Role;

use Controller\Admin;
use Lib\Data\AlbumCategory;
use Lib\Data\Permission;
use Lib\Data\Speltak;

/**
 * Class Role
 * @package Controller\Admin\Role
 */
class Role extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('role.edit');

        $role = \Lib\Data\Role::getById($_GET['id']);
        if (!$role) {
            $role = new \Lib\Data\Role(
                null,
                '',
                false
            );
        }

        return [
            'role' => $role,
            'permissions' => Permission::findForRole($role),
            'albumCategories' => AlbumCategory::getAll(),
            'groups' => Speltak::getAll(),
            'downloads' => [['name' => 'report'],['name' => 'newsletter']]
        ];
    }
}