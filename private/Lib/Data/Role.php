<?php

namespace Lib\Data;
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

    /**
     * @return Role[]
     */
    public static function getAll()
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `flg_role`"
        );

        $roles = [];
        foreach ($data as $role) {
            $roles[] = self::bindSqlResult($role);
        }

        return $roles;
    }

    /**
     * @param int $id
     * @return Role
     */
    public static function getById($id)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `flg_role` WHERE id = ?",
            [$id],
            'i'
        );

        if ($data) {
            return self::bindSqlResult($data);
        }

        return null;
    }

    /**
     * @param string $name
     * @return Role
     */
    public static function getByName($name)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `flg_role` WHERE `name` = ?",
            [$name],
            's'
        );

        if ($data) {
            return self::bindSqlResult($data);
        }

        return null;
    }

    /**
     * @param array $data
     * @return Role
     */
    private static function bindSqlResult($data)
    {
        return new Role(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'name'),
            Util::arrayGet($data, 'isAdmin')
        );
    }

    /**
     *
     */
    public function save()
    {
        $db = \Lib\Core\Database::getInstance();
        $params = [
            $this->getName(),
            intval($this->getIsAdmin())
        ];

        $types = 'si';
        if ($this->getId() === null || $this->getId() === 0) {
            $sql = "INSERT INTO `flg_role` (`name`, `isAdmin`) VALUES ( ?, ? )";
            $result = $db->query($sql, $params, $types);
            $this->setId($result->insert_id);
        } else {
            $sql = "UPDATE `flg_role` SET `name` = ?, `isAdmin` = ? WHERE `id` = ?";
            $params[] = $this->getId();
            $types .= 'i';
            $db->query($sql, $params, $types);
        }
    }

    /**
     *
     */
    public function clearPermissions()
    {
        \Lib\Core\Database::getInstance()->query(
            "DELETE FROM `flg_rolePermission` WHERE roleId = ?",
            [$this->getId()],
            'i'
        );
    }

    /**
     *
     */
    public function delete()
    {
        \Lib\Core\Database::getInstance()->query(
            "DELETE FROM `flg_role` WHERE id = ?",
            [$this->getId()],
            'i'
        );
    }

    public function addPermission(Permission $permission)
    {
        \Lib\Core\Database::getInstance()->query(
            "INSERT INTO `flg_rolePermission` (`roleId`, `permissionId`) VALUES ( ?, ? )",
            [$this->getId(), $permission->getId()],
            'ii'
        );
    }

    /**
     * @param int $userId
     * @return array
     */
    public static function findByUserId($userId)
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `flg_role` WHERE id IN (SELECT roleId FROM `flg_userRole` WHERE userId = ?)",
            [$userId],
            'i'
        );

        $roles = [];
        foreach ($data as $role) {
            $roles[] = self::bindSqlResult($role);
        }

        return $roles;
    }
}