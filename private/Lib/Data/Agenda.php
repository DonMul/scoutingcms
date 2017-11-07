<?php

namespace Lib\Data;

use Lib\Core\Database;
use Lib\Core\Util;

/**
 * Class Agenda
 * @package Lib\Data
 */
final class Agenda
{
    const TABLENAME = 'agenda';

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
    private $startDate;

    /**
     * @var string
     */
    private $endDate;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $category;

    /**
     * Agenda constructor.
     * @param int $id
     * @param string $name
     * @param string $startDate
     * @param string $endDate
     * @param string $description
     * @param string $slug
     * @param string $category
     */
    public function __construct($id, $name, $startDate, $endDate, $description, $slug, $category)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setStartDate($startDate);
        $this->setEndDate($endDate);
        $this->setDescription($description);
        $this->setSlug($slug);
        $this->setCategory($category);
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
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param string $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param string $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
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
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    private static function getTableName()
    {
        return Database::getInstance()->getFullTableName(self::TABLENAME);
    }

    /**
     * @return Agenda[]
     */
    public static function getAll()
    {
        $data = Database::getInstance()->fetchAll(
            "SELECT * FROM `" . self::getTableName() . "`"
        );

        $agendaItems = [];
        foreach ($data as $agendaItem) {
            $agendaItems[] = self::bindSqlResult($agendaItem);
        }

        return $agendaItems;
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param bool   $reverseOrder
     * @return Agenda[]
     */
    public static function findBetweenDates($startDate, $endDate, $reverseOrder = false)
    {
        $query = "SELECT * FROM `" . self::getTableName() . "` WHERE startDate > ? AND endDate < ?";
        if ($reverseOrder) {
            $query .= " ORDER BY startDate DESC";
        }

        $data = \Lib\Core\Database::getInstance()->fetchAll($query, [$startDate, $endDate], 'ss');

        $agendaItems = [];
        foreach ($data as $agendaItem) {
            $agendaItems[] = self::bindSqlResult($agendaItem);
        }

        return $agendaItems;
    }

    /**
     * @param int $id
     * @return Agenda
     */
    public static function getById($id)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `" . self::getTableName() . "` WHERE id = ?",
            [
                $id
            ],
            'i'
        );

        if ($data) {
            return self::bindSqlResult($data);
        }

        return null;
    }

    /**
     * @param string $slug
     * @return Agenda
     */
    public static function getBySlug($slug)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `" . self::getTableName() . "` WHERE slug = ?",
            [
                $slug
            ],
            's'
        );

        if ($data) {
            return self::bindSqlResult($data);
        }

        return null;
    }


    /**
     * @param $data
     * @return Agenda
     */
    private static function bindSqlResult($data) {
        return new Agenda(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'name'),
            Util::arrayGet($data, 'startDate'),
            Util::arrayGet($data, 'endDate'),
            Util::arrayGet($data, 'description'),
            Util::arrayGet($data, 'slug'),
            Util::arrayGet($data, 'category')
        );
    }

    /**
     *
     */
    public function save()
    {
        $db = Database::getInstance();
        $params = [
            $this->getName(),
            $this->getStartDate(),
            $this->getEndDate(),
            $this->getDescription(),
            $this->getSlug(),
            $this->getCategory(),
        ];

        $types = 'ssssss';
        if ($this->getId() === null || $this->getId() === 0) {
            $sql = "INSERT INTO `" . self::getTableName() . "` (`name`, `startDate`, `endDate`, `description`, `slug`, `category`) VALUES ( ?, ?, ?, ?, ?, ? )";
        } else {
            $sql = "UPDATE `" . self::getTableName() . "` SET `name` = ?, `startDate` = ?, `endDate` = ?, `description` = ?, `slug` = ?, `category` = ? WHERE `id` = ?";
            $params[] = $this->getId();
            $types .= 'i';
        }

        $result = $db->query($sql, $params, $types);
        $this->setId($result->insert_id);
    }

    /**
     *
     */
    public function delete()
    {
        $result =  Database::getInstance()->query("DELETE FROM `" . self::getTableName() . "` WHERE id = ?", [$this->getId()], 'i');
        return $result->affected_rows > 0;
    }

    /**
     * @return int
     */
    public static function getTotalAmount()
    {
        $result = Database::getInstance()->fetchOne("SELECT count(1) AS cnt FROM `" . self::getTableName() . "`");
        return Util::arrayGet($result, 'cnt', 0);
    }
}