<?php

namespace Lib\Data;
use Lib\Core\Database;
use Lib\Core\Util;

/**
 * Class Picture
 * @package Lib\Data
 */
final class Picture
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $albumId;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $title;

    /**
     * Picture constructor.
     * @param int $id
     * @param int $albumId
     * @param string $location
     * @param string $title
     */
    public function __construct($id, $albumId, $location, $title)
    {
        $this->setId($id);
        $this->setAlbumId($albumId);
        $this->setLocation($location);
        $this->setTitle($title);
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
     * @return int
     */
    public function getAlbumId()
    {
        return $this->albumId;
    }

    /**
     * @param int $albumId
     */
    public function setAlbumId($albumId)
    {
        $this->albumId = $albumId;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return Picture[]
     */
    public static function getAll()
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `flg_picture`"
        );

        $pictures = [];
        foreach ($data as $picture) {
            $pictures[] = self::bindSqlResult($picture);
        }

        return $pictures;
    }

    /**
     * @param int $albumId
     * @return Picture[]
     */
    public static function findByAlbumId($albumId)
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `flg_picture` WHERE albumId = ?",
            [$albumId],
            'i'
        );

        $pictures = [];
        foreach ($data as $picture) {
            $pictures[] = self::bindSqlResult($picture);
        }

        return $pictures;
    }

    /**
     * @param $data
     * @return Picture
     */
    private static function bindSqlResult($data)
    {
        return new Picture(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'albumId'),
            Util::arrayGet($data, 'location'),
            Util::arrayGet($data, 'title')
        );
    }

    public function save()
    {
        $db = \Lib\Core\Database::getInstance();
        $params = [
            $this->getAlbumId(),
            $this->getLocation(),
            $this->getTitle(),
        ];

        $types = 'iss';
        if ($this->getId() === null || $this->getId() === 0) {
            $sql = "INSERT INTO `flg_picture` (`albumId`, `location`, `title`) VALUES ( ?, ?, ? )";
        } else {
            $sql = "UPDATE `flg_album` SET `albumId` = ?, `location` = ?, `title` = ? WHERE `id` = ?";
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
        $result = Database::getInstance()->fetchOne("SELECT count(1) AS cnt FROM `flg_picture`");
        return Util::arrayGet($result, 'cnt', 0);
    }
}