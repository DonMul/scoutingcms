<?php

namespace Controller;

/**
 * Class NewsItem
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class NewsItem extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'article' => $this->getNewsRepository()->getById($this->getVariable('id', 0)),
        ];
    }
}
