<?php

namespace Lib\Data;

use Lib\Core\Database;
use Lib\Core\Util;

/**
 * Class Album
 * @package Lib\Data
 */
final class Album
{
    const TABLENAME = 'album';

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
    private $slug;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $category;

    /**
     * @var string
     */
    private $thumbnail;

    /**
     * @var bool
     */
    private $private;

    /**
     * Album constructor.
     * @param int $id
     * @param string $name
     * @param string $slug
     * @param string $description
     * @param string $category
     * @param string $thumbnail
     */
    public function __construct($id, $name, $slug, $description, $category, $thumbnail, $private)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setSlug($slug);
        $this->setDescription($description);
        $this->setCategory($category);
        $this->setThumbnail($thumbnail);
        $this->setPrivate($private);
    }

    /**
     * @return bool
     */
    public function isPrivate()
    {
        return $this->private;
    }

    /**
     * @param bool $private
     */
    public function setPrivate($private)
    {
        $this->private = $private;
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
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return string
     */
    private static function getTableName()
    {
        return Database::getInstance()->getFullTableName(self::TABLENAME);
    }

    /**
     * @return Album[]
     */
    public static function getAll()
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `" . self::getTableName() . "`"
        );

        $albums = [];
        foreach ($data as $album) {
            $albums[] = self::bindSqlResult($album);
        }

        return $albums;
    }

    /**
     * @param int $category
     * @return Album[]
     */
    public static function findByCategory($category)
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `" . self::getTableName() . "` WHERE category = ?",
            [$category],
            'i'
        );

        $albums = [];
        foreach ($data as $album) {
            $albums[] = self::bindSqlResult($album);
        }

        return $albums;
    }

    /**
     * @param $category
     * @return array
     */
    public static function findPublicByCategory($category)
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `" . self::getTableName() . "` WHERE category = ? AND private = ?",
            [$category, 0],
            'ii'
        );

        $albums = [];
        foreach ($data as $album) {
            $albums[] = self::bindSqlResult($album);
        }

        return $albums;
    }

    /**
     * @param int $id
     * @return Album
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
     * @param $category
     * @param $slug
     * @return Album|null
     */
    public static function getByCategoryAndSlug($category, $slug)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `" . self::getTableName() . "` WHERE category = ? AND slug = ?",
            [$category, $slug],
            'ss'
        );

        if ($data) {
            return self::bindSqlResult($data);
        }

        return null;
    }

    /**
     * @param array $data
     * @return Album
     */
    private static function bindSqlResult($data)
    {
        return new Album(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'name'),
            Util::arrayGet($data, 'slug'),
            Util::arrayGet($data, 'description'),
            Util::arrayGet($data, 'category'),
            Util::arrayGet($data, 'thumbnail'),
            Util::arrayGet($data, 'private')
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
            $this->getSlug(),
            $this->getDescription(),
            $this->getCategory(),
            $this->getThumbnail(),
            intval($this->isPrivate()),
        ];

        $types = 'sssssi';
        if ($this->getId() === null || $this->getId() === 0) {
            $sql = "INSERT INTO `" . self::getTableName() . "` (`name`, `slug`, `description`, `category`, `thumbnail`, `private`) VALUES ( ?, ?, ?, ?, ?, ? )";
        } else {
            $sql = "UPDATE `" . self::getTableName() . "` SET `name` = ?, `slug` = ?, `description` = ?, `category` = ?, `thumbnail` = ?, `private` = ? WHERE `id` = ?";
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
        $result =  \Lib\Core\Database::getInstance()->query("DELETE FROM `" . self::getTableName() . "` WHERE id = ?", [$this->getId()], 'i');
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

    /**
     * @return AlbumCategory
     */
    public function getCategoryObject()
    {
        return AlbumCategory::getById($this->getCategory());
    }
}