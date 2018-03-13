<?php

namespace Lib\Core;

/**
 * Class Dispatcher
 * @package Lib\Core
 * @author Joost Mul <scoutingcms@jmul.net>
 */
class Dispatcher extends \Lib\Core\Singleton
{
    /**
     * @param $url
     */
    public function dispatchUrl($url)
    {
        $urlData = \Lib\Core\Sitemap::getInstance()->getDataForUrl($url);

        if (!$urlData) {
            $urlData = \Lib\Core\Sitemap::getInstance()->getDataForUrl('/404');
            http_response_code(404);
        }

        /**
         * @var \Lib\Core\BaseController $class
         */
        $class = new $urlData['controller'];
        $class->execute();
    }
}
