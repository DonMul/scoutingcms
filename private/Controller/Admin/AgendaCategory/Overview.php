<?php

namespace Controller\Admin\AgendaCategory;

use Controller\Admin;
use Lib\Data\AgendaCategory;

/**
 * Class Overview
 * @package Controller\Admin\AgendaCategory
 */
class Overview extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $categories = AgendaCategory::getAll();
        return [
            'categories' => $categories
        ];
    }
}