<?php

namespace Controller;

class NewsItem extends \Lib\Core\BaseController
{
    public function getArray()
    {
        return [
            'article' => \Lib\Data\News::getById($_GET['id']),
        ];
    }
}