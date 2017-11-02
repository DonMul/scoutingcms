<?php

namespace Controller\Admin\AlbumCategory;

use Controller\Admin;
use Lib\Data;

/**
 * Class AlbumCategory
 * @package Controller\Admin\AlbumCategory
 */
class AlbumCategory extends Admin
{
    public function getArray()
    {
        $category = Data\AlbumCategory::getById($_GET['id']);
        if (!$category) {
            $category = new Data\AlbumCategory(null, '');
        }

        return [
            'category' => $category,
        ];
    }
}