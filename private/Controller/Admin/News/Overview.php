<?php

namespace Controller\Admin\News;

use Controller\Admin;

/**
 * Class Overview
 * @package Controller\Admin\News
 */
class Overview extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('news.edit');

        return [
            'news' => \Lib\Data\News::getAll(),
            'active' => 'news',
        ];
    }
}