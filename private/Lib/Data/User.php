<?php

namespace Lib\Data;

/**
 * Class User
 * @package Data
 * @author Joost Mul <scoutingcms@jmul.net>
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
}
