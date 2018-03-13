<?php

namespace Lib\Data;

/**
 * Class Speltak
 * @package Lib\Data
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Speltak
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
    private $picture;

    /**
     * @var string
     */
    private $description;

    /**
     * Speltak constructor.
     * @param int $id
     * @param string $name
     * @param string $picture
     * @param string $description
     */
    public function __construct(?int $id, string $name, string $picture, string $description)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setPicture($picture);
        $this->setDescription($description);
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

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture(string $picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }
}
