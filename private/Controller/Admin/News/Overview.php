<?php

namespace Controller\Admin\News;

use Lib\Core\BaseController;

/**
 * Class Overview
 * @package Controller\Admin\News
 */
class Overview extends BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'news' => \Lib\Data\News::getAll()
        ];
    }
}