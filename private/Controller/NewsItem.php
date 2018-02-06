<?php

namespace Controller;

/**
 * Class NewsItem
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
class NewsItem extends \Lib\Core\BaseController
{
    public function getArray()
    {
        return [
            'article' => \Lib\Data\News::getById($_GET['id']),
        ];
    }
}
