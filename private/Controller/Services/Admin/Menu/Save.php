<?php

namespace Controller\Services\Admin\Menu;

use Controller\Services\Admin;
use Lib\Core\Cache;
use Lib\Core\Util;
use Lib\Data\Menu;

/**
 * Class Save
 * @package Controller\Services\Admin\Menu
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Save extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('menu.edit');

        foreach ($this->getMenuRepository()->getAll() as $menu) {
            $menu->delete();
        }

        /**
         * @var Menu[] $menuItems
         */
        $menuItems = [];
        $keyIdMapping = [];
        foreach ($this->getPostValue(['menu', 'name']) as $key => $name) {
            $item = new Menu(
                0,
                0,
                $name,
                $this->getPostValue(['menu', 'type', $key]),
                $this->getPostValue(['menu', 'value', $key]),
                $this->getPostValue(['menu', 'position', $key])
            );

            $this->getMenuRepository()->save($item);
            $menuItems[$key] = $item;
            $keyIdMapping[$this->getPostValue(['menu', 'id', $key])] = $item->getId();
        }

        foreach ($this->getPostValue(['menu', 'parent']) as $key => $parentId) {
            $menuItems[$key]->setParentId(Util::arrayGet($keyIdMapping, $parentId, 0));
            $menuItems[$key]->save();
        }

        Cache::getInstance()->unset('globalMenu');
        return [
            'reload' => true,
        ];
    }
}
