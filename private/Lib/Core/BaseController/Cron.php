<?php

namespace Lib\Core\BaseController;

use Lib\Core\Settings;
use Lib\Core\Util;

/**
 * Class Cron
 * @package Lib\Core\BaseController
 * @author Joost Mul <scoutingcms@jmul.net>
 */
abstract class Cron
{
    /**
     *
     */
    public final function execute()
    {
        $shouldExecute = $this->shouldExecute();

        if ($shouldExecute !== true) {
            exit;
        }

        $this->runCron();
    }

    /**
     * @return bool
     */
    protected function shouldExecute()
    {
        $hash = Util::arrayGet($_GET, 'hash', '');
        return $hash === Settings::getInstance()->get('cron-hash');
    }

    /**
     * @return mixed
     */
    protected abstract function runCron();
}
