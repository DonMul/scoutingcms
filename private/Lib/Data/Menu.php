<?php

namespace Lib\Data;


use Lib\Core\Cache;
use Lib\Core\Database;
use Lib\Core\Translation;
use Lib\Core\Util;

final class Menu
{
    const TABLENAME = 'menu';

    const TYPE_PAGE = 'page';
    const TYPE_ALBUM = 'album';
    const TYPE_CALENDER = 'calender';
    const TYPE_GROUP = 'group';
    const TYPE_DOWNLOAD = 'download';
    const TYPE_URL = 'url';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $value;

    /**
     * @var int
     */
    private $position;

    /**
     * @var Menu[]
     */
    private $subItems = [];

    /**
     * @var int
     */
    private $parentId;

    /**
     * Menu constructor.
     * @param int $id
     * @param string $name
     * @param string $type
     * @param string $value
     */
    public function __construct($id, $parentId, $name, $type, $value, $position)
    {
        $this->id = $id;
        $this->parentId = $parentId;
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position)
    {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     */
    public function setParentId(int $parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return string
     */
    private static function getTableName()
    {
        return Database::getInstance()->getFullTableName(self::TABLENAME);
    }

    /**
     * @return Menu[]
     */
    public static function getAll()
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `" . self::getTableName() . "`"
        );

        $menuItems = [];
        foreach ($data as $menuItem) {
            $menuItems[] = self::bindSqlResult($menuItem);
        }

        return $menuItems;
    }

    /**
     * @param array $data
     * @return Menu
     */
    private static function bindSqlResult($data)
    {
        return new Menu(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'parentId'),
            Util::arrayGet($data, 'name'),
            Util::arrayGet($data, 'type'),
            Util::arrayGet($data, 'value'),
            Util::arrayGet($data, 'position')
        );
    }

    /**
     * @param Menu $item
     */
    public function addSubItem(Menu $item)
    {
        $this->subItems[$item->getPosition()] = $item;
    }

    /**
     * @return Menu[]
     */
    public function getSubItems()
    {
        return $this->subItems;
    }

    /**
     * @return Menu[]
     */
    public static function getNestedObjectStructure()
    {
        $allMenus = self::getAll();
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
     * @return Menu[]
     */
    public static function getNestedStructure()
    {
        $cacheKey = 'globalMenu';
        $cache = Cache::getInstance()->get($cacheKey);
        if ($cache !== null) {
            return $cache;
        }

        $menuIdMapping = self::getNestedObjectStructure();

        $mapping = [];
        foreach ($menuIdMapping as $item) {
            $mapping[$item->getPosition()] = self::getData($item);
        }

        Cache::getInstance()->set($cacheKey, $mapping);
        return $mapping;
    }

    /**
     * @param Menu $item
     * @return array
     */
    private static function getData(Menu $item)
    {
        $url = '';
        switch ($item->getType()) {
            case self::TYPE_ALBUM:
                $album = AlbumCategory::getByName($item->getValue());
                $url = Translation::getInstance()->translateLink('albums', ['category' => $album->getName()]);
                break;
            case self::TYPE_URL:
                $url = $item->getValue();
                break;
            case self::TYPE_PAGE:
                $page = Page::getBySlug($item->getValue());
                $url = $page->getSlug();
                break;
            case self::TYPE_GROUP:
                $group = Speltak::getByName($item->getValue());
                $url = Translation::getInstance()->translateLink('speltak', ['name' => $group->getName()]);
                break;
            case self::TYPE_DOWNLOAD:
                $url = Translation::getInstance()->translateLink('download', ['type' => $item->getValue()]);
                break;
        }

        $subItems = [];
        foreach ($item->getSubItems() as $subItem) {
            $subItems[$subItem->getPosition()] = self::getData($subItem);
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
    public function save()
    {
        $db = Database::getInstance();
        $params = [
            $this->getParentId(),
            $this->getName(),
            $this->getType(),
            $this->getValue(),
            $this->getPosition(),
        ];

        $types = 'isssi';
        if ($this->getId() === null || $this->getId() == 0) {
            $sql = "INSERT INTO `" . self::getTableName() . "` (`parentId`, `name`, `type`, `value`, `position`) VALUES ( ?, ?, ?, ?, ? )";
            $result = $db->query($sql, $params, $types);
            $insertId = $result->insert_id;
            $this->setId($insertId);
        } else {
            $sql = "UPDATE `" . self::getTableName() . "` SET `parentId` = ?, `name` = ?, `type` = ?, `value` = ?, `position` = ? WHERE `id` = ?";
            $params[] = $this->getId();
            $types .= 'i';
            $db->query($sql, $params, $types);
        }
    }

    /**
     *
     */
    public function delete()
    {
        $sql = "DELETE FROM `" . self::getTableName() . "` WHERE id = ?";
        Database::getInstance()->query($sql, [$this->getId()], 'i');
    }
}