<?php

namespace Controller\Services;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul
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
}