<?php

namespace Lib\Repository;

use \Lib\Core\Util;
use \Lib\Data;

/**
 * Class Data\Permission
 * @package Lib\Repository
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Permission extends BaseRepository
{
    private const TABLENAME = 'permission';

    /**
     * @return string
     */
    private function getTableName(): string
    {
        return $this->getDatabase()->getFullTableName(self::TABLENAME);
    }

    /**
     * @return Data\Permission[]
     */
    public function getAll(): array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "`"
        );

        $permissions = [];
        foreach ($data as $permission) {
            $permissions[] = $this->bindSqlResult($permission);
        }

        return $permissions;
    }

    /**
     * @param int $id
     * @return Data\Permission
     */
    public function getById(int $id): ?Data\Permission
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
     * @return Data\Permission
     */
    public function getByName(string $name): ?Data\Permission
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
     * @param Data\Role $role
     * @return Data\Permission
     */
    public function findForRole(Data\Role $role) : array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM flg_permission WHERE flg_permission.id IN (SELECT permissionId FROM `" . $this->getDatabase()->getFullTableName('rolePermission') . "` WHERE roleId = ?)",
            [$role->getId()],
            'i'
        );

        $permissions = [];
        foreach ($data as $permission) {
            $permissions[] = $this->bindSqlResult($permission);
        }

        return $permissions;
    }

    /**
     * @param array $data
     * @return Data\Permission
     */
    private function bindSqlResult(array $data) : ?Data\Permission
    {
        return new Data\Permission(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'name')
        );
    }

    /**
     * @param Data\Permission $permission;
     */
    public function save(Data\Permission $permission)
    {
        $db = $this->getDatabase();
        $params = [
            $permission->getName()
        ];

        $types = 's';
        if ($permission->getId() === null || $permission->getId() === 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "` (`name`) VALUES ( ? )";
        } else {
            $sql = "UPDATE `" . $this->getTableName() . "` SET `name` = ? WHERE `id` = ?";
            $params[] = $permission->getId();
            $types .= 'i';
        }

        $result = $db->query($sql, $params, $types);
        $permission->setId($result->insert_id);
    }
}
