<?php

namespace Controller\Services\User;

use Lib\Core\BaseController\Ajax;
use Lib\Core\Translation;
use Lib\Data\User;

class Register extends Ajax
{
    public function getArray()
    {
        $username = $this->getPostValue('username');
        $user = User::getByUsername($username);
        if ($user instanceof User) {
            throw new \Exception(Translation::getInstance()->translate('error.user.usernameAlreadyExists'));
        }

        $password = $this->getPostValue('password');
        $repeatPassword = $this->getPostValue('passwordRepeat');
        $email = $this->getPostValue('email');
        $nickName = $this->getPostValue('nick');

        if ($password != $repeatPassword) {
            throw new \Exception(Translation::getInstance()->translate('error.user.passwordsDoNotMatch'));
        }

        $user = new User(
            null,
            $username,
            $password,
            $nickName,
            $email
        );

        $user->setPassword($password, true);
        $user->save();

        return [
            'message' => Translation::getInstance()->translate('success.user.registration')
        ];
    }
}