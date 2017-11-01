<?php

namespace Controller\Admin\News;

use Controller\Admin;

/**
 * Class NewsItem
 * @package Controller\Admin
 */
class NewsItem extends Admin
{
    /**
     *
     */
    public function getArray()
    {
        $this->ensurePermission('news.edit');

        $newsItem = \Lib\Data\News::getById($_GET['id']);
        if (!$newsItem) {
            $newsItem = new \Lib\Data\News(null, "New news", '', date("Y-m-d H:i:s"), \Lib\Data\News::STATUS_DRAFT);
        }

        return [
            'newsItem' => $newsItem,
            'active' => 'news',
        ];
    }
}