<?php

namespace Controller\Services\User;

use Lib\Core\BaseController\Ajax;
use Lib\Core\Translation;
use Lib\Core\Validate;
use Lib\Data\User;
use Lib\Exception\InvalidPassword;
use Lib\Exception\UserException;

/**
 * Class Register
 * @package Controller\Services\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Register extends Ajax
{
    public function getArray()
    {
        $username = $this->getPostValue('username');
        $user = $this->getUserRepository()->getByUsername($username);
        if ($user instanceof User) {
            throw new UserException(Translation::getInstance()->translate('error.user.usernameAlreadyExists'));
        }

        $password = $this->getPostValue('password');
        $repeatPassword = $this->getPostValue('passwordRepeat');
        $email = $this->getPostValue('email');
        $nickName = $this->getPostValue('nick');

        if ($password != $repeatPassword) {
            throw new UserException(Translation::getInstance()->translate('error.user.passwordsDoNotMatch'));
        }

        $user = new User(
            null,
            $username,
            $password,
            $nickName,
            $email
        );

        if (!Validate::getInstance()->isValidPassword($password)) {
            throw new InvalidPassword();
        }

        $user->setPassword($password, true);
        $this->getUserRepository()->save($user);

        return [
            'message' => Translation::getInstance()->translate('success.user.registration')
        ];
    }
}
