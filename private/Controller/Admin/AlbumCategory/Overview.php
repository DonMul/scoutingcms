<?php

namespace Controller\Admin\AlbumCategory;

use Controller\Admin;

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
        $categories = $this->getAlbumCategoryRepository()->getAll();
        return [
            'categories' => $categories
        ];
    }
}
