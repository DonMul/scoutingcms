<?php

namespace Lib\Repository;

use \Lib\Core\Util;
use \Lib\Data;

/**
 * Class User
 * @package Lib\Repository
 */
final class User extends BaseRepository
{
    const TABLENAME = 'user';

    /**
     * @return string
     */
    private function getTableName(): string
    {
        return $this->getDatabase()->getFullTableName(self::TABLENAME);
    }

    /**
     * @param int $id
     * @return Data\User
     */
    public function getById(int $id): ?Data\User
    {
        $data = $this->getDatabase()->fetchOne(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE id = ?",
            [$id],
            'i'
        );

        if (!$data) {
            return null;
        }

        return $this->bindSqlResult($data);
    }

    /**
     * @param array $data
     * @return Data\User
     */
    private function bindSqlResult(array $data): Data\User
    {
        return new Data\User(
            $data['id'],
            $data['username'],
            $data['password'],
            $data['nickname'],
            $data['email']
        );
    }

    /**
     *
     */
    public function delete(Data\User $user): bool
    {
        $result = $this->getDatabase()->fetchOne(
            "DELETE FROM `" . $this->getTableName() . "` WHERE id = ?",
            [$user->getId()],
            'i'
        );

        return $result->affected_rows > 0;
    }

    /**
     * @param string $username
     * @return Data\User
     */
    public function getByUsername(string $username): ?Data\User
    {
        $data = $this->getDatabase()->fetchOne(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE username = ?",
            [$username],
            's'
        );

        if (!$data) {
            return null;
        }

        return $this->bindSqlResult($data);
    }

    /**
     * @param Data\User $user
     */
    public function save(Data\User $user)
    {
        $db = $this->getDatabase();
        $params = [
            $user->getUsername(),
            $user->getPassword(),
            $user->getNickname(),
            $user->getEmail(),
        ];

        $types = 'ssss';
        if ($user->getId() === null || $user->getId() === 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "` (`username`, `password`, `nickname`, `email`) VALUES ( ?, ?, ?, ? )";
            $result = $db->query($sql, $params, $types);
            $user->setId($result->insert_id);
        } else {
            $sql = "UPDATE `" . $this->getTableName() . "` SET `username` = ?, `password` = ?, `nickname` = ?, `email` = ? WHERE `id` = ?";
            $params[] = $user->getId();
            $types .= 'i';
            $db->query($sql, $params, $types);
        }
    }

    /**
     * @return int
     */
    public function getTotalAmount(): int
    {
        $result = $this->getDatabase()->fetchOne("SELECT COUNT(1) AS cnt FROM `" . $this->getTableName() . "`");
        return Util::arrayGet($result, 'cnt', 0);
    }

    /**
     * @return Data\User[]
     */
    public function getAll() : array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "`"
        );

        $users = [];
        foreach ($data as $user) {
            $users[] = $this->bindSqlResult($user);
        }

        return $users;
    }

    /**
     * @param Data\User $user
     * @return Data\Role[]
     */
    public function getRoles(Data\User $user) : array
    {
        return (new Role())->findByUserId($user->getId());
    }

    /**
     *
     */
    public function clearRoles(Data\User $user)
    {
        $this->getDatabase()->query(
            "DELETE FROM `flg_userRole` WHERE Data\UserId = ?",
            [$user->getId()],
            'i'
        );
    }

    /**
     * @param Data\User $user
     * @param Data\Role $role
     */
    public function addRole(Data\User $user, Data\Role $role)
    {
        $this->getDatabase()->query(
            "INSERT INTO `flg_userRole` (`userId`, `roleId`) VALUES ( ?, ? )",
            [$user->getId(), $role->getId()],
            'ii'
        );
    }

    /**
     * @return array
     */
    public function getPermissions(Data\User $user) : array
    {
        $permissions = [];
        $roles = $this->getRoles($user);
        foreach ($roles as $role) {
            $permissions = array_merge($permissions, (new Permission())->findForRole($role));
        }

        $permissionNames = [];
        foreach ($permissions as $permission) {
            $permissionNames[] = $permission->getName();
        }

        $permissionNames = array_unique($permissionNames);
        return $permissionNames;
    }
}
