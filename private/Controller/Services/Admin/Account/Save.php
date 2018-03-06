<?php

namespace Controller\Services\Admin\Account;

use Controller\Services\Admin;
use Lib\Core\Session;
use Lib\Core\Translation;
use Lib\Core\Validate;
use Lib\Data\User;
use Lib\Exception\InvalidPassword;

/**
 * Class Save
 * @package Controller\Services\Admin\Account
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Save extends Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $user = $this->getUserRepository()->getById(Session::getInstance()->getKey());
        if (!$user instanceof User) {
            throw new \Exception(Translation::getInstance()->translate('error.user.notFound'));
        }

        $password = $this->getPostValue('password');
        $repeatPassword = $this->getPostValue('passwordRepeat');
        if (!empty($password)) {
            if ($password != $repeatPassword) {
                throw new \Exception(Translation::getInstance()->translate('error.user.passwordsDoNotMatch'));
            }
            if (Validate::getInstance()->isValidPassword($password) === true) {
                $user->setPassword($password, true);
            } else {
                throw new InvalidPassword();
            }
        }
        $user->setNickname($this->getPostValue('nickname'));
        $user->setEmail($this->getPostValue('email'));

        $this->getUserRepository()->save($user);

        return [
            'reload' => true,
        ];
    }
}
