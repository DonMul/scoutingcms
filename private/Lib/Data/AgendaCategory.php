<?php

namespace Lib\Data;
use Lib\Core\Util;

/**
 * Class AgendaCategory
 * @package Lib\Data
 */
final class AgendaCategory
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
     * @return AgendaCategory[]
     */
    public static function getAll()
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `flg_agendaCategory`"
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
            "SELECT * FROM `flg_agendaCategory` WHERE id = ?",
            [$id],
            'i'
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
            Util::arrayGet($data, 'name')
        );
    }
}