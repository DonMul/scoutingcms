<?php

namespace Controller\Services\Admin\Role;

use Controller\Services\Admin;
use Lib\Core\Translation;
use Lib\Data\Permission;
use Lib\Data\Role;

/**
 * Class Save
 * @package Controller\Services\Admin\Role
 */
final class Save extends Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $this->ensurePermission('role.edit');

        $roleId = $this->getPostValue('roleId');
        $role = $this->getRoleRepository()->getById($roleId);
        if (!($role instanceof Role) && intval($roleId) > 0) {
            throw new \Exception(Translation::getInstance()->translate("error.role.notFound", ['id' => $roleId]));
        }

        if ($role) {
            $role->setName($this->getPostValue('name'));
            $role->setIsAdmin(isset($_POST['isAdmin']));
        } else {
            $role = new Role(
                null,
                $this->getPostValue('name'),
                isset($_POST['isAdmin'])
            );
        }

        $this->getRoleRepository()->save($role);
        $this->getRoleRepository()->clearPermissions($role);

        foreach ($this->getPostValue('permission') as $permissionName => $enabled) {
            $permission = $this->getPermissionRepository()->getByName($permissionName);
            if (!($permission instanceof Permission)) {
                $permission = new Permission(null, $permissionName);
                $permission->save();
            }

            $this->getRoleRepository()->addPermission($role, $permission);
        }

        $_SESSION['permissions'] = null;
        return [
            'redirect' => Translation::getInstance()->translateLink('adminRoles')
        ];
    }
}
