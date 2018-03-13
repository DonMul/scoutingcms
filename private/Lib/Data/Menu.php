<?php

namespace Lib\Data;

/**
 * Class Menu
 * @package Lib\Data
 * @author Joost Mul <scoutingcms@jmul.net>
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
     * @param int $parentId
     * @param string $name
     * @param string $type
     * @param string $value
     * @param int $position
     */
    public function __construct(?int $id, int $parentId, string $name, string $type, $value, int $position)
    {
        $this->setId($id);
        $this->setParentId($parentId);
        $this->setName($name);
        $this->setType($type);
        $this->setValue($value);
        $this->setPosition($position);
    }

    /**
     * @return int
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
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
    public function getType(): string
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
    public function getValue(): string
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
    public function getPosition(): int
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
    public function getParentId(): int
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
    public function getSubItems(): array
    {
        return $this->subItems;
    }
}
