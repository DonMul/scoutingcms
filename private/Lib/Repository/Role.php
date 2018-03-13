<?php

namespace Lib\Repository;

use Lib\Core\Util;
use Lib\Data;

/**
 * Class Data\Role
 * @package Lib\Repository
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Role extends BaseRepository
{
    const TABLENAME = 'role';

    /**
     * @return string
     */
    private function getTableName() : string
    {
        return $this->getDatabase()->getFullTableName(self::TABLENAME);
    }

    /**
     * @return Data\Role[]
     */
    public function getAll() : array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "`"
        );

        $roles = [];
        foreach ($data as $role) {
            $roles[] = $this->bindSqlResult($role);
        }

        return $roles;
    }

    /**
     * @param int $id
     * @return Data\Role
     */
    public function getById(int $id) : ?Data\Role
    {
        $data = $this->getDatabase()->fetchOne(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE id = ?",
            [$id],
            'i'
        );

        if ($data) {
            return $this->bindSqlResult($data);
        }

        return null;
    }

    /**
     * @param string $name
     * @return Data\Role
     */
    public function getByName(string $name) : ?Data\Role
    {
        $data = $this->getDatabase()->fetchOne(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE `name` = ?",
            [$name],
            's'
        );

        if ($data) {
            return $this->bindSqlResult($data);
        }

        return null;
    }

    /**
     * @param array $data
     * @return Data\Role
     */
    private function bindSqlResult(array $data) : Data\Role
    {
        return new Data\Role(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'name'),
            Util::arrayGet($data, 'isAdmin')
        );
    }

    /**
     *
     */
    public function save(Data\Role $role)
    {
        $db = $this->getDatabase();
        $params = [
            $role->getName(),
            intval($role->getIsAdmin())
        ];

        $types = 'si';
        if ($role->getId() === null || $role->getId() === 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "` (`name`, `isAdmin`) VALUES ( ?, ? )";
            $result = $db->query($sql, $params, $types);
            $role->setId($result->insert_id);
        } else {
            $sql = "UPDATE `" . $this->getTableName() . "` SET `name` = ?, `isAdmin` = ? WHERE `id` = ?";
            $params[] = $role->getId();
            $types .= 'i';
            $db->query($sql, $params, $types);
        }
    }

    /**
     * @param Data\Role $role
     */
    public function clearPermissions(Data\Role $role)
    {
        $this->getDatabase()->query(
            "DELETE FROM `" . $this->getTableName() . "` WHERE RoleId = ?",
            [$role->getId()],
            'i'
        );
    }

    /**
     * @param Data\Role $role
     * @return bool
     */
    public function delete(Data\Role $role) : bool
    {
        $result = $this->getDatabase()->query(
            "DELETE FROM `" . $this->getTableName() . "` WHERE id = ?",
            [$role->getId()],
            'i'
        );

        return $result->affected_rows > 0;
    }

    /**
     * @param Data\Role $role
     * @param Data\Permission $permission
     */
    public function addPermission(Data\Role $role, Data\Permission $permission)
    {
        $this->getDatabase()->query(
            "INSERT INTO `" . $this->getTableName() . "` (`roleId`, `permissionId`) VALUES ( ?, ? )",
            [$role->getId(), $permission->getId()],
            'ii'
        );
    }

    /**
     * @param int $userId
     * @return Data\Role[]
     */
    public function findByUserId(int $userId) : array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE id IN (SELECT RoleId FROM `" . $this->getDatabase()->getFullTableName('userRole') . "` WHERE userId = ?)",
            [$userId],
            'i'
        );

        $roles = [];
        foreach ($data as $role) {
            $roles[] = $this->bindSqlResult($role);
        }

        return $roles;
    }
}
