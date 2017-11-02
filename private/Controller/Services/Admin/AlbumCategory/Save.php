<?php

namespace Controller\Services\Admin\AlbumCategory;

use Controller\Services\Admin;
use Lib\Core\Translation;
use Lib\Data\AgendaCategory;
use Lib\Data\AlbumCategory;

/**
 * Class Save
 * @package Controller\Services\Admin\CalenderCategory
 */
class Save extends Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $categoryId = $this->getPostValue('categoryId');
        $category = AlbumCategory::getById($categoryId);
        if (!($category instanceof AlbumCategory) && intval($categoryId) > 0) {
            throw new \Exception(Translation::getInstance()->translate("error.albumCategory.notFound", ['id' => $categoryId]));
        }

        if ($category) {
            $category->setName($this->getPostValue('name'));
        } else {
            $category = new AlbumCategory(
                null,
                $this->getPostValue('name')
            );
        }

        $category->save();

        return [
            'redirect' => Translation::getInstance()->translateLink('adminAlbumCategories')
        ];
    }
}