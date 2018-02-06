<?php

namespace Lib\Data;
use Lib\Core\Database;
use Lib\Core\Util;

/**
 * Class Role
 * @package Lib\Data
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
    public function __construct($id, $name, $isAdmin)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setIsAdmin($isAdmin);
    }

    /**
     * @return string
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param string $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
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
    public function setName($name)
    {
        $this->name = $name;
    }
}
