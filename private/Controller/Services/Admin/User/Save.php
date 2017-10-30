<?php

namespace Controller\Services\Admin\User;
use Lib\Core\Translation;
use Lib\Core\Util;
use Lib\Data\Page;
use Lib\Data\Role;
use Lib\Data\User;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul
 */
class Save extends \Controller\Services\Admin
{
    /**
     * @throws \Exception
     */
    public function getArray()
    {
        $userId = $this->getPostValue('userId');
        $user = \Lib\Data\User::getById($userId);
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
            $user->setPassword($newPassword, true);
        }

        $user->save();
        $user->clearRoles();
        foreach ($this->getPostValue(['role']) as $roleId => $enabled) {
            $role = Role::getById($roleId);
            $user->addRole($role);
        }

        return [
            'redirect' => Translation::getInstance()->translateLink("adminUsers")
        ];
    }
}