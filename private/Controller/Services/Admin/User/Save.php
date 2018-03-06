<?php

namespace Controller\Services\Admin\User;

use Lib\Core\Translation;
use Lib\Core\Util;
use Lib\Core\Validate;
use Lib\Data\Page;
use Lib\Data\Role;
use Lib\Data\User;
use Lib\Exception\InvalidPassword;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Save extends \Controller\Services\Admin
{
    /**
     * @throws \Exception
     */
    public function getArray()
    {
        $this->ensurePermission('user.edit');

        $userId = $this->getPostValue('userId');
        $user =$this->getUserRepository()->getById($userId);
        if (!($user instanceof User) && intval($userId) > 0) {
            throw new \Exception(Translation::getInstance()->translate("error.user.notFound"));
        }

        if ($user) {
            $user->setUsername($this->getPostValue('username'));
            $user->setNickname($this->getPostValue('nickname'));
            $user->setEmail($this->getPostValue('email'));
        } else {
            $user = new User(
                null,
                $this->getPostValue('username'),
                '',
                $this->getPostValue('nickname'),
                $this->getPostValue('email')
            );
        }

        $newPassword = $this->getPostValue('password');
        if (!empty($newPassword)) {
            if (Validate::getInstance()->isValidPassword($newPassword) === true) {
                $user->setPassword($newPassword, true);
            } else {
                throw new InvalidPassword();
            }
        }

        $this->getUserRepository()->save($user);
        $this->getUserRepository()->clearRoles($user);
        foreach ($this->getPostValue(['role']) as $roleId => $enabled) {
            $role = $this->getRoleRepository()->getById($roleId);
            $this->getUserRepository()->addRole($user, $role);
        }

        return [
            'redirect' => Translation::getInstance()->translateLink("adminUsers")
        ];
    }
}
