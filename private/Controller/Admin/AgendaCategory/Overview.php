<?php

namespace Controller\Admin\AgendaCategory;

use Controller\Admin;

/**
 * Class Overview
 * @package Controller\Admin\AgendaCategory
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Overview extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $categories = $this->getAgendaCategoryRepository()->getAll();
        return [
            'categories' => $categories
        ];
    }
}
