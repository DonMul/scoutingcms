<?php

namespace Lib\Data;
use Lib\Core\Util;

/**
 * Class Permission
 * @package Lib\Data
 */
final class Permission
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
     * AgendaCategory constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct($id, $name)
    {
        $this->setId($id);
        $this->setName($name);
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
     * @return Permission[]
     */
    public static function getAll()
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `flg_permission`"
        );

        $permissions = [];
        foreach ($data as $permission) {
            $permissions[] = self::bindSqlResult($permission);
        }

        return $permissions;
    }

    /**
     * @param int $id
     * @return Permission
     */
    public static function getById($id)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `flg_permission` WHERE id = ?",
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
     * @return Permission
     */
    public static function getByName($name)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `flg_permission` WHERE `name` = ?",
            [$name],
            's'
        );

        if ($data) {
            return self::bindSqlResult($data);
        }

        return null;
    }

    /**
     * @param Role $role
     * @return array
     */
    public static function findForRole(Role $role)
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM flg_permission WHERE flg_permission.id IN (SELECT permissionId FROM `flg_rolePermission` WHERE roleId = ?)",
            [$role->getId()],
            'i'
        );

        $permissions = [];
        foreach ($data as $permission) {
            $permissions[] = self::bindSqlResult($permission);
        }

        return $permissions;
    }

    /**
     * @param array $data
     * @return Permission
     */
    private static function bindSqlResult($data)
    {
        return new Permission(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'name')
        );
    }

    /**
     *
     */
    public function save()
    {
        $db = \Lib\Core\Database::getInstance();
        $params = [
            $this->getName()
        ];

        $types = 's';
        if ($this->getId() === null || $this->getId() === 0) {
            $sql = "INSERT INTO `flg_permission` (`name`) VALUES ( ? )";
        } else {
            $sql = "UPDATE `flg_permission` SET `name` = ? WHERE `id` = ?";
            $params[] = $this->getId();
            $types .= 'i';
        }

        $result = $db->query($sql, $params, $types);
        $this->setId($result->insert_id);
    }
}