<?php

namespace Controller;

/**
 * Class Index
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Index extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'page' => $this->getPageRepository()->getHomepage(),
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
