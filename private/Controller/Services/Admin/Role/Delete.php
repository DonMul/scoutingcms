<?php

namespace Controller\Services\Admin\Role;

use Lib\Core\Translation;
use Lib\Data\Role;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Delete extends \Controller\Services\Admin
{
    /**
     * @throws \Exception
     */
    public function getArray()
    {
        $this->ensurePermission('role.edit');

        $roleId = $this->getPostValue('roleId');
        $role = $this->getRoleRepository()->getById($roleId);
        if (!($role instanceof Role)) {
            throw new \Exception(Translation::getInstance()->translate("error.role.notFound", ['id' => $roleId]));
        }

        $this->getRoleRepository()->delete($role);

        return [
            'reload' => true,
        ];
    }
}
