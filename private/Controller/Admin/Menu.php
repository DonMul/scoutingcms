<?php

namespace Controller\Admin;

use Controller\Admin;

/**
 * Class Menu
 * @package Controller\Admin
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Menu extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('menu.edit');

        return [
            'menu' => $this->getMenuRepository()->getNestedObjectStructure(),
        ];
    }
}
