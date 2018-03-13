<?php

namespace Lib\Data;

/**
 * Class Role
 * @package Lib\Data
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Role
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
    private $isAdmin;

    /**
     * Role constructor.
     * @param int       $id
     * @param string    $name
     * @param bool      $isAdmin
     */
    public function __construct(?int $id, string $name, bool $isAdmin)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setIsAdmin($isAdmin);
    }

    /**
     * @return bool
     */
    public function getIsAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin(bool $isAdmin)
    {
        $this->isAdmin = $isAdmin;
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
