<?php

namespace Controller\Services\Admin\AlbumCategory;

use Controller\Services\Admin;
use Lib\Core\Translation;
use Lib\Data\AgendaCategory;
use Lib\Data\AlbumCategory;

/**
 * Class Save
 * @package Controller\Services\Admin\CalenderCategory
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Save extends Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $categoryId = $this->getPostValue('categoryId');
        $category = $this->getAlbumCategoryRepository()->getById($categoryId);
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

        $this->getAlbumCategoryRepository()->save($category);

        return [
            'redirect' => Translation::getInstance()->translateLink('adminAlbumCategories')
        ];
    }
}
