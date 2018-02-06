<?php

namespace Controller\Services\Admin\User;

use Lib\Core\Translation;
use Lib\Data\User;

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
        $this->ensurePermission('user.edit');

        $userId = $this->getPostValue('userId');
        $user = User::getById($userId);
        if (!($user instanceof User)) {
            throw new \Exception(Translation::getInstance()->translate("error.user.notFound"));
        }

        $user->delete();

        return [
            'reload' => true,
        ];
    }
}
