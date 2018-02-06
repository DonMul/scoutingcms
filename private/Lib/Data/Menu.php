<?php

namespace Lib\Data;

use Lib\Core\Cache;
use Lib\Core\Database;
use Lib\Core\Translation;
use Lib\Core\Util;

/**
 * Class Menu
 * @package Lib\Data
 */
final class Menu
{
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
}
