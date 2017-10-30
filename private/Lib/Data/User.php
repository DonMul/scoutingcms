<?php

namespace Lib\Data;

use Lib\Core\Database;
use Lib\Core\Util;

/**
 * Class User
 * @package Data
 */
final class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @var string
     */
    private $email;

    /**
     * User constructor.
     * @param int       $id
     * @param string    $username
     * @param string    $password
     * @param string    $nickname
     * @param string    $email
     */
    public function __construct($id, $username, $password, $nickname, $email)
    {
        $this->setId($id);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setNickname($nickname);
        $this->setEmail($email);
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param int    $password
     * @Param string $hashPassword
     */
    public function setPassword($password, $hashPassword = false)
    {
        if ($hashPassword) {
            $password = $this->hashPassword($password);
        }

        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param int $id
     * @return User
     */
    public static function getById($id)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `flg_user` WHERE id = ?",
            [$id],
            'i'
        );

        if (!$data) {
            return null;
        }

        return self::bindSqlResult($data);
    }

    /**
     * @param array $data
     * @return User
     */
    private static function bindSqlResult($data)
    {
        return new self(
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
    public function delete()
    {
        \Lib\Core\Database::getInstance()->fetchOne(
            "DELETE FROM `flg_user` WHERE id = ?",
            [$this->getId()],
            'i'
        );
    }

    /**
     * @param string    $username
     * @return User
     */
    public static function getByUsername($username)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `flg_user` WHERE username = ?",
            [$username],
            's'
        );

        if (!$data) {
            return null;
        }

        return self::bindSqlResult($data);
    }

    /**
     * @param string $password
     * @return string
     */
    private function hashPassword($password)
    {
        return hash('sha512', $password);
    }

    /**
     * @param string $password
     * @return bool
     */
    public function verifyPassword($password)
    {
        return hash('sha512', $password) == $this->getPassword();
    }

    /**
     *
     */
    public function save()
    {
        $db = \Lib\Core\Database::getInstance();
        $params = [
            $this->getUsername(),
            $this->getPassword(),
            $this->getNickname(),
            $this->getEmail(),
        ];

        $types = 'ssss';
        if ($this->getId() === null || $this->getId() === 0) {
            $sql = "INSERT INTO `flg_user` (`username`, `password`, `nickname`, `email`) VALUES ( ?, ?, ?, ? )";
            $result = $db->query($sql, $params, $types);
            $this->setId($result->insert_id);
        } else {
            $sql = "UPDATE `flg_user` SET `username` = ?, `password` = ?, `nickname` = ?, `email` = ? WHERE `id` = ?";
            $params[] = $this->getId();
            $types .= 'i';
            $db->query($sql, $params, $types);
        }
    }

    /**
     * @return int
     */
    public static function getTotalAmount()
    {
        $result = Database::getInstance()->fetchOne("SELECT count(1) AS cnt FROM `flg_user`");
        return Util::arrayGet($result, 'cnt', 0);
    }

    /**
     * @return User[]
     */
    public static function getAll()
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `flg_user`"
        );

        $users = [];
        foreach ($data as $user) {
            $users[] = self::bindSqlResult($user);
        }

        return $users;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return Role::findByUserId($this->getId());
    }

    /**
     *
     */
    public function clearRoles()
    {
        \Lib\Core\Database::getInstance()->query("DELETE FROM `flg_userRole` WHERE userId = ?",
            [$this->getId()],
            'i'
        );
    }

    /**
     * @param Role $role
     */
    public function addRole(Role $role)
    {
        \Lib\Core\Database::getInstance()->query("INSERT INTO `flg_userRole` (`userId`, `roleId`) VALUES ( ?, ? )",
            [$this->getId(), $role->getId()],
            'ii'
        );
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        $permissions = [];
        $roles = $this->getRoles();
        foreach ($roles as $role) {
            $permissions = array_merge($permissions, Permission::findForRole($role));
        }

        $permissionNames = [];
        foreach ($permissions as $permission) {
            $permissionNames[] = $permission->getName();
        }

        $permissionNames = array_unique($permissionNames);
        return $permissionNames;
    }
}