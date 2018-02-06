<?php

namespace Controller\Services\Admin\CalenderCategory;

use Controller\Services\Admin;
use Lib\Core\Translation;
use Lib\Data\AgendaCategory;

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
        $category = $this->getAgendaCategoryRepository()->getById($categoryId);
        if (!($category instanceof AgendaCategory)) {
            throw new \Exception(Translation::getInstance()->translate("error.calenderCategory.notFound", ['id' => $categoryId]));
        }

        if ($category) {
            $category->setName($this->getPostValue('name'));
            $category->setColor($this->getPostValue('color'));
        } else {
            $category = new AgendaCategory(
                null,
                $this->getPostValue('name'),
                $this->getPostValue('color')
            );
        }

        $this->getAgendaCategoryRepository()->save($category);

        return [
            'redirect' => Translation::getInstance()->translateLink('adminCalenderCategories')
        ];
    }
}
