<?php

namespace Controller\Admin\AlbumCategory;

use Controller\Admin;
use Lib\Data\AlbumCategory;

/**
 * Class Overview
 * @package Controller\Admin\AlbumCategory
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Overview extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $categories = AlbumCategory::getAll();
        return [
            'categories' => $categories
        ];
    }
}
