<?php

namespace Controller\Admin\Page;

use Controller\Admin;

/**
 * Class Overview
 * @package Controller\Admin
 */
class Overview extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'pages' => \Lib\Data\Page::getAll(),
        ];
    }
}