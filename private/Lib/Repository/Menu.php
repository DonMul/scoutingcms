<?php

namespace Lib\Repository;

use Lib\Core\Cache;
use Lib\Core\Translation;
use \Lib\Core\Util;
use \Lib\Data;

/**
 * Class Menu
 * @package Lib\Repository
 */
final class Menu extends BaseRepository
{
    const TABLENAME = 'menu';

    /**
     * @return string
     */
    private function getTableName()
    {
        return $this->getDatabase()->getFullTableName(self::TABLENAME);
    }

    /**
     * @return Data\Menu[]
     */
    public function getAll() : array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "`"
        );

        $menuItems = [];
        foreach ($data as $menuItem) {
            $menuItems[] = $this->bindSqlResult($menuItem);
        }

        return $menuItems;
    }

    /**
     * @param array $data
     * @return Data\Menu
     */
    private function bindSqlResult(array $data) : ?Data\Menu
    {
        return new Data\Menu(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'parentId'),
            Util::arrayGet($data, 'name'),
            Util::arrayGet($data, 'type'),
            Util::arrayGet($data, 'value'),
            Util::arrayGet($data, 'position')
        );
    }

    /**
     * @return Data\Menu[]
     */
    public function getNestedObjectStructure() : array
    {
        $allMenus = $this->getAll();
        $menuIdMapping = [];
        foreach ($allMenus as $menu) {
            $menuIdMapping[$menu->getId()] = $menu;
        }

        foreach ($allMenus as $menu) {
            if ($menu->getParentId() == 0) {
                continue;
            }

            $menuIdMapping[$menu->getParentId()]->addSubItem($menu);
        }

        foreach ($allMenus as $menu) {
            if ($menu->getParentId() != 0) {
                unset($menuIdMapping[$menu->getId()]);
                continue;
            }
        }

        return $menuIdMapping;
    }

    /**
     * @return Data\Menu[]
     */
    public function getNestedStructure() : array
    {
        $cacheKey = 'globalMenu';
        $cache = Cache::getInstance()->get($cacheKey);
        if ($cache !== null) {
            return $cache;
        }

        $menuIdMapping = $this->getNestedObjectStructure();

        $mapping = [];
        foreach ($menuIdMapping as $item) {
            $mapping[$item->getPosition()] = $this->getData($item);
        }

        Cache::getInstance()->set($cacheKey, $mapping);
        return $mapping;
    }

    /**
     * @param Data\Menu $item
     * @return array
     */
    private function getData(Data\Menu $item) : array
    {
        $url = '';
        switch ($item->getType()) {
            case \Lib\Data\Menu::TYPE_ALBUM:
                $album = (new AlbumCategory())->getByName($item->getValue());
                $url = Translation::getInstance()->translateLink('albums', ['category' => $album->getName()]);
                break;
            case \Lib\Data\Menu::TYPE_URL:
                $url = $item->getValue();
                break;
            case \Lib\Data\Menu::TYPE_PAGE:
                $page = (new Page())->getBySlug($item->getValue());
                $url = $page->getSlug();
                break;
            case \Lib\Data\Menu::TYPE_GROUP:
                $group = (new Speltak())->getByName($item->getValue());
                $url = Translation::getInstance()->translateLink('speltak', ['name' => $group->getName()]);
                break;
            case \Lib\Data\Menu::TYPE_DOWNLOAD:
                $url = Translation::getInstance()->translateLink('download', ['type' => $item->getValue()]);
                break;
        }

        $subItems = [];
        foreach ($item->getSubItems() as $subItem) {
            $subItems[$subItem->getPosition()] = $this->getData($subItem);
        }

        return [
            'name' => $item->getName(),
            'url' => $url,
            'subItems' => $subItems
        ];
    }

    /**
     *
     */
    public function save(Data\Menu $menu)
    {
        $db = $this->getDatabase();
        $params = [
            $menu->getParentId(),
            $menu->getName(),
            $menu->getType(),
            $menu->getValue(),
            $menu->getPosition(),
        ];

        $types = 'isssi';
        if ($menu->getId() === null || $menu->getId() == 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "` (`parentId`, `name`, `type`, `value`, `position`) VALUES ( ?, ?, ?, ?, ? )";
            $result = $db->query($sql, $params, $types);
            $insertId = $result->insert_id;
            $menu->setId($insertId);
        } else {
            $sql = "UPDATE `" . $this->getTableName() . "` SET `parentId` = ?, `name` = ?, `type` = ?, `value` = ?, `position` = ? WHERE `id` = ?";
            $params[] = $menu->getId();
            $types .= 'i';
            $db->query($sql, $params, $types);
        }
    }

    /**
     * @param Data\Menu $menu
     */
    public function delete(Data\Menu $menu)
    {
        $sql = "DELETE FROM `" . $this->getTableName() . "` WHERE id = ?";
        $this->getDatabase()->query($sql, [$menu->getId()], 'i');
    }
}
