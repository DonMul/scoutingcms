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
        $category = AgendaCategory::getById($_GET['id']);
        if (!$category) {
            $category = new AgendaCategory(null, '', '');
        }

        return [
            'category' => $category,
        ];
    }
}
