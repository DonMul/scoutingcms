<?php

namespace Controller\Admin\AlbumCategory;

use Controller\Admin;
use Lib\Data;

/**
 * Class AlbumCategory
 * @package Controller\Admin\AlbumCategory
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class AlbumCategory extends Admin
{
    public function getArray()
    {
        $category = $this->getAlbumCategoryRepository()->getById($this->getVariable('id', 0));
        if (!$category) {
            $category = new Data\AlbumCategory(null, '');
        }

        return [
            'category' => $category,
        ];
    }
}
