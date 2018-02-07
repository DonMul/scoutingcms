<?php

namespace Controller\Services;

use Lib\Core\Translation;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
abstract class Admin extends \Lib\Core\BaseController\Ajax
{
    /**
     * Admin constructor.
     */
    public function __construct()
    {
        $this->setRequiresLogin(true);
    }

    /**
     * @param string $permissionName
     * @throws \Exception
     */
    protected function ensurePermission($permissionName)
    {
        if (!$this->hasPermission($permissionName)) {
            throw new \Exception(Translation::getInstance()->translate('error.noPermission'));
        }
    }
}
