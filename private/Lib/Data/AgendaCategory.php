<?php

namespace Lib\Data;

/**
 * Class AgendaCategory
 * @package Lib\Data
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class AgendaCategory
{
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
    private $color;

    /**
     * AgendaCategory constructor.
     * @param int $id
     * @param string $name
     * @param string $color
     */
    public function __construct(?int $id, string $name, string $color)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setColor($color);
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color)
    {
        $this->color = $color;
    }

    /**
     * @return int
     */
    public function getId(): ?int
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
}
