<?php

namespace Lib\Data;
use Lib\Core\Database;
use Lib\Core\Util;

/**
 * Class AlbumCategory
 * @package Lib\Data
 */
final class AlbumCategory
{
    const TABLENAME = 'albumCategory';

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
     * @return string
     */
    private static function getTableName()
    {
        return Database::getInstance()->getFullTableName(self::TABLENAME);
    }

    /**
     * @return AlbumCategory[]
     */
    public static function getAll()
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `" . self::getTableName() . "`"
        );

        $albumCategories = [];
        foreach ($data as $albumCategory) {
            $albumCategories[] = self::bindSqlResult($albumCategory);
        }

        return $albumCategories;
    }

    /**
     * @param int $id
     * @return AlbumCategory
     */
    public static function getById($id)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `" . self::getTableName() . "` WHERE id = ?",
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
     * @return AlbumCategory
     */
    public static function getByName($name)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `" . self::getTableName() . "` WHERE `name` = ?",
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
     * @return AlbumCategory
     */
    private static function bindSqlResult($data)
    {
        return new AlbumCategory(
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
            $this->getName(),
        ];

        $types = 's';
        if ($this->getId() === null || $this->getId() === 0) {
            $sql = "INSERT INTO `" . self::getTableName() . "` (`name`) VALUES ( ? )";
        } else {
            $sql = "UPDATE `" . self::getTableName() . "` SET `name` = ? WHERE `id` = ?";
            $params[] = $this->getId();
            $types .= 'i';
        }

        $result = $db->query($sql, $params, $types);
        $this->setId($result->insert_id);
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $result =  \Lib\Core\Database::getInstance()->query("DELETE FROM `" . self::getTableName() . "` WHERE id = ?", [$this->getId()], 'i');
        return $result->affected_rows > 0;
    }
}