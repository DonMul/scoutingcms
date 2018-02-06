<?php

namespace Controller\Services\User;

use Lib\Core\Translation;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Login extends \Lib\Core\BaseController\Ajax
{
    /**
     * @throws \Exception
     */
    public function getArray()
    {
        $isValid = false;
        $user = \Lib\Data\User::getByUsername($this->getPostValue('username'));
        if ($user) {
            $isValid = $user->verifyPassword($this->getPostValue('password'));
        }

        if (!$isValid) {
            throw new \Exception(Translation::getInstance()->translate('error.user.invalidUsernameOrPassword'));
        }

        \Lib\Core\Session::getInstance()->logIn($user->getId());

        return ['reload' => true];
    }
}
