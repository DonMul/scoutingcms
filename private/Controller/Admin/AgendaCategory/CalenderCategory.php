<?php

namespace Controller\Admin\AgendaCategory;

use Controller\Admin;
use Lib\Data\AgendaCategory;

/**
 * Class CalenderCategory
 * @package Controller\Admin\AgendaCategory
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class CalenderCategory extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $category = $this->getAgendaCategoryRepository()->getById($this->getVariable('id', 0));
        if (!$category) {
            $category = new AgendaCategory(null, '', '');
        }

        return [
            'category' => $category,
        ];
    }
}
