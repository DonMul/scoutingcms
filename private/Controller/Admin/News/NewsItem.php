<?php

namespace Controller\Admin\News;

use Controller\Admin;

/**
 * Class NewsItem
 * @package Controller\Admin
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class NewsItem extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('news.edit');

        $newsItem = $this->getNewsRepository()->getById($this->getVariable('id', 0));
        if (!$newsItem) {
            $newsItem = new \Lib\Data\News(null, "New news", '', date("Y-m-d H:i:s"), \Lib\Data\News::STATUS_DRAFT);
        }

        return [
            'newsItem' => $newsItem,
            'active' => 'news',
            'isNew' => $newsItem->getId() == null,
        ];
    }
}
