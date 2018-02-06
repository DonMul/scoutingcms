<?php

namespace Controller;

use Lib\Data\Album;
use Lib\Data\AlbumCategory;

/**
 * Class Albums
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
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
