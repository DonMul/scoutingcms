<?php

namespace Controller\CronJob;

use Lib\Core\Settings;
use Lib\Core\Util;

/**
 * Class Facebook
 * @package Controller\CronJob
 * @author Joost Mul <scoutingcms@jmul.net>
 */
abstract class Facebook extends \Lib\Core\BaseController\Cron
{
    /**
     * @return bool
     */
    protected function shouldExecute()
    {
        $fbSettings = Settings::getInstance()->get('facebook', []);
        $enabled = Util::arrayGet($fbSettings, 'enabled', false);

        return $enabled === true && parent::shouldExecute();
    }

    /**
     * @return \Facebook\Facebook
     */
    protected final function getFbClient()
    {
        $fbSettings = Settings::getInstance()->get('facebook', []);
        $fb = new \Facebook\Facebook([
            'app_id' => Util::arrayGet($fbSettings, 'appId', ''),
            'app_secret' => Util::arrayGet($fbSettings, 'appSecret', ''),
            'default_graph_version' => Util::arrayGet($fbSettings, 'graphVersion', ''),
            'default_access_token' => Util::arrayGet($fbSettings, 'token', ''),
        ]);

        return $fb;
    }

    /**
     * @return int
     */
    protected final function getPageId()
    {
        return Settings::getInstance()->get(['facebook', 'page'], 0);
    }
}
