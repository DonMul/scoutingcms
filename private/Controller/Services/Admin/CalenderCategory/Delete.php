<?php

namespace Controller\Services\Admin\CalenderCategory;

use Controller\Services\Admin;
use Lib\Core\Translation;
use Lib\Data\AgendaCategory;

/**
 * Class Delete
 * @package Controller\Services\Admin\CalenderCategory
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Delete extends Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $categoryId = $this->getPostValue('categoryId');
        $category = $this->getAgendaCategoryRepository()->getById($categoryId);
        if (!($category instanceof AgendaCategory) && intval($categoryId) > 0) {
            throw new \Exception(Translation::getInstance()->translate("error.calenderCategory.notFound", ['id' => $categoryId]));
        }

        $this->getAgendaCategoryRepository()->delete($category);

        return [
            'redirect' => Translation::getInstance()->translateLink('adminCalenderCategories')
        ];
    }
}
