<?php

namespace Controller\Admin\Role;

use Controller\Admin;

/**
 * Class Role
 * @package Controller\Admin\Role
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Role extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('role.edit');

        $role = $this->getRoleRepository()->getById($this->getVariable('id', 0));
        if (!$role) {
            $role = new \Lib\Data\Role(
                null,
                '',
                false
            );
        }

        return [
            'role' => $role,
            'permissions' => $this->getPermissionRepository()->findForRole($role),
            'albumCategories' => $this->getAlbumCategoryRepository()->getAll(),
            'groups' => $this->getSpeltakRepository()->getAll(),
            'downloads' => [['name' => 'report'],['name' => 'newsletter']],
            'active' => 'role'
        ];
    }
}
