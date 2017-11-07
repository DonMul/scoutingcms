<?php

namespace Controller\Admin;

use Controller\Admin;

/**
 * Class Menu
 * @package Controller\Admin
 */
class Menu extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('menu.edit');

        return [
            'menu' => \Lib\Data\Menu::getNestedObjectStructure(),
        ];
    }
}