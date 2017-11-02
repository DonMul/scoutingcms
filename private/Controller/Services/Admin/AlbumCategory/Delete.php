<?php

namespace Controller\Services\Admin\AlbumCategory;

use Controller\Admin\AlbumCategory\AlbumCategory;
use Controller\Services\Admin;
use Lib\Core\Translation;

/**
 * Class Delete
 * @package Controller\Services\Admin\CalenderCategory
 */
class Delete extends Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $categoryId = $this->getPostValue('categoryId');
        $category = \Lib\Data\AlbumCategory::getById($categoryId);
        if (!($category instanceof \Lib\Data\AlbumCategory)) {
            throw new \Exception(Translation::getInstance()->translate("error.albumCategory.notFound", ['id' => $categoryId]));
        }

        $category->delete();

        return [
            'redirect' => Translation::getInstance()->translateLink('adminAlbumCategories')
        ];
    }
}