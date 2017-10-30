<?php

namespace Lib\Data;

use Lib\Core\Database;
use Lib\Core\Util;

/**
 * Class Download
 * @package Lib\Data
 */
final class Download
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
    private $type;

    /**
     * @var string
     */
    private $filename;

    const TYPE_REPORT = 'report';
    const TYPE_NEWSLETTER = 'newsletter';

    /**
     * Download constructor.
     * @param int $id
     * @param string $name
     * @param string $type
     * @param string $filename
     */
    public function __construct($id, $name, $type, $filename)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setType($type);
        $this->setFilename($filename);
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return Download[]
     */
    public static function getAll()
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `flg_download`"
        );

        $downloads = [];
        foreach ($data as $download) {
            $downloads[] = self::bindSqlResult($download);
        }

        return $downloads;
    }

    /**
     * @param array $data
     * @return Download
     */
    private static function bindSqlResult($data)
    {
        return new Download(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'name'),
            Util::arrayGet($data, 'type'),
            Util::arrayGet($data, 'filename')
        );
    }

    /**
     * @param int $id
     * @return Download
     */
    public static function getById($id)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `flg_download` WHERE id = ?",
            [$id],
            'i'
        );

        if ($data) {
            return self::bindSqlResult($data);
        }

        return null;
    }

    /**
     *
     */
    public function save()
    {
        $db = \Lib\Core\Database::getInstance();
        $params = [
            $this->getName(),
            $this->getType(),
            $this->getFilename(),
        ];

        $types = 'sss';
        if ($this->getId() === null || $this->getId() === 0) {
            $sql = "INSERT INTO `flg_download` (`name`, `type`, `filename`) VALUES ( ?, ?, ? )";
        } else {
            $sql = "UPDATE `flg_download` SET `name` = ?, `type` = ?, `filename` = ? WHERE `id` = ?";
            $params[] = $this->getId();
            $types .= 'i';
        }

        $result = $db->query($sql, $params, $types);
        $this->setId($result->insert_id);
    }

    /**
     * @return Download[]
     */
    public static function findByType($type)
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `flg_download` WHERE type = ? ORDER BY id DESC",
            [$type],
            's'
        );

        $downloads = [];
        foreach ($data as $download) {
            $downloads[] = self::bindSqlResult($download);
        }

        return $downloads;
    }

    /**
     *
     */
    public function delete()
    {
        $result =  \Lib\Core\Database::getInstance()->query("DELETE FROM `flg_download` WHERE id = ?", [$this->getId()], 'i');
        return $result->affected_rows > 0;
    }

    /**
     * @return int
     */
    public static function getTotalAmount()
    {
        $result = Database::getInstance()->fetchOne("SELECT count(1) AS cnt FROM `flg_download`");
        return Util::arrayGet($result, 'cnt', 0);
    }
}