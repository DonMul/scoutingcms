<?php

namespace Lib\Data;
use Lib\Core\Util;

/**
 * Class AlbumCategory
 * @package Lib\Data
 */
final class AlbumCategory
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
     * @return AlbumCategory[]
     */
    public static function getAll()
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `flg_albumCategory`"
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
            "SELECT * FROM `flg_albumCategory` WHERE id = ?",
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
            "SELECT * FROM `flg_albumCategory` WHERE `name` = ?",
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
}