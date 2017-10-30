<?php

namespace Controller\Services\Admin\Role;

use Lib\Core\Translation;
use Lib\Data\Role;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul
 */
class Delete extends \Controller\Services\Admin
{
    /**
     * @throws \Exception
     */
    public function getArray()
    {
        $this->ensurePermission('role.edit');

        $roleId = $this->getPostValue('roleId');
        $role = Role::getById($roleId);
        if (!($role instanceof Role)) {
            throw new \Exception(Translation::getInstance()->translate("error.role.notFound", ['id' => $roleId]));
        }

        $role->delete();

        return [
            'reload' => true,
        ];
    }
}