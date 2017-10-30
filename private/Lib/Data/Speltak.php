<?php

namespace Lib\Data;

use Lib\Core\Database;
use Lib\Core\Util;

/**
 * Class Speltak
 * @package Lib\Data
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
     * @param int    $id
     * @param string $name
     * @param string $picture
     * @param string $description
     */
    public function __construct($id, $name, $picture, $description)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setPicture($picture);
        $this->setDescription($description);
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
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Speltak[]
     */
    public static function getAll()
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `flg_speltak`"
        );

        $speltakken = [];
        foreach ($data as $speltak) {
            $speltakken[] = self::bindSqlResult($speltak);
        }

        return $speltakken;
    }

    /**
     * @param int $id
     * @return Speltak
     */
    public static function getById($id)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `flg_speltak` WHERE id = ?",
            [$id],
            'i'
        );

        if (!$data) {
            return null;
        }

        return self::bindSqlResult($data);
    }

    /**
     * @param int $name
     * @return Speltak
     */
    public static function getByName($name)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `flg_speltak` WHERE name = ?",
            [$name],
            's'
        );

        if (!$data) {
            return null;
        }

        return self::bindSqlResult($data);
    }

    /**
     * @param array $data
     * @return Speltak
     */
    private static function bindSqlResult($data)
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['picture'],
            $data['description']
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
            $this->getDescription(),
            $this->getPicture()
        ];

        $types = 'sss';
        if ($this->getId() === null || $this->getId() === 0) {
            $sql = "INSERT INTO `flg_speltak` (`name`, `description`, `picture`) VALUES ( ?, ?, ? )";
        } else {
            $sql = "UPDATE `flg_speltak` SET `name` = ?, `description` = ?, `picture` = ? WHERE `id` = ?";
            $params[] = $this->getId();
            $types .= 'i';
        }

        $result = $db->query($sql, $params, $types);
        $this->setId($result->insert_id);
    }

    /**
     * @return int
     */
    public static function getTotalAmount()
    {
        $result = Database::getInstance()->fetchOne("SELECT count(1) AS cnt FROM `flg_speltak`");
        return Util::arrayGet($result, 'cnt', 0);
    }
}