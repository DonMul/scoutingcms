<?php

namespace Controller\Admin\News;

use Lib\Core\BaseController;
use Lib\Core\Settings;
use Lib\Data\Picture;

/**
 * Class NewsItem
 * @package Controller\Admin
 */
class NewsItem extends BaseController
{
    /**
     *
     */
    public function getArray()
    {
        $newsItem = \Lib\Data\News::getById($_GET['id']);
        if (!$newsItem) {
            $newsItem = new \Lib\Data\News(null, "New news", '', date("Y-m-d H:i:s"), \Lib\Data\News::STATUS_DRAFT);
        }

        return [
            'newsItem' => $newsItem
        ];
    }
}