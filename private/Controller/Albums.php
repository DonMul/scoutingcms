<?php

namespace Controller;


use Lib\Data\Album;
use Lib\Data\AlbumCategory;

class Albums extends \Lib\Core\BaseController
{
    public function getArray()
    {
        $category = AlbumCategory::getByName($_GET['category']);

        return [
            'albums' => Album::findPublicByCategory($category->getId()),
            'categories' => AlbumCategory::getAll(),
        ];
    }
}