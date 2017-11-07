<?php

namespace Lib\Data;
use Lib\Core\Database;
use Lib\Core\Util;

/**
 * Class AgendaCategory
 * @package Lib\Data
 */
final class AgendaCategory
{
    const TABLENAME = 'agendaCategory';

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
    private $color;

    /**
     * AgendaCategory constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct($id, $name, $color)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setColor($color);
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
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
     * @return AgendaCategory[]
     */
    public static function getAll()
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `" . self::getTableName() . "`"
        );

        $agendaCategories = [];
        foreach ($data as $agendaCategory) {
            $agendaCategories[] = self::bindSqlResult($agendaCategory);
        }

        return $agendaCategories;
    }

    /**
     * @param int $id
     * @return AgendaCategory
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
     * @return AgendaCategory
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
     * @return AgendaCategory
     */
    private static function bindSqlResult($data)
    {
        return new AgendaCategory(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'name'),
            Util::arrayGet($data, 'color')
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
            $this->getColor(),
        ];

        $types = 'ss';
        if ($this->getId() === null || $this->getId() === 0) {
            $sql = "INSERT INTO `" . self::getTableName() . "` (`name`, `color`) VALUES ( ?, ? )";
        } else {
            $sql = "UPDATE `" . self::getTableName() . "` SET `name` = ?, `color` = ? WHERE `id` = ?";
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