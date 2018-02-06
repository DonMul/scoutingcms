<?php

namespace Controller;

/**
 * Class Index
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
class Index extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        $page = \Lib\Data\Page::getHomepage();
        return [
            'page' => $page
        ];
    }

    /**
     * @return string
     */
    protected function getTitle()
    {
        return \Lib\Core\Translation::getInstance()->translate("title.index");
    }
} 
