<?php

namespace Lib\Data;

use Lib\Core\Database;
use Lib\Core\Util;

/**
 * Class News
 * @package Lib\Data
 */
final class News
{
    const TABLENAME = 'news';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $published;

    /**
     * @var string
     */
    private $status;

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';

    /**
     * News constructor.
     * @param int $id
     * @param string $title
     * @param string $content
     * @param string $published
     * @param string $status
     */
    public function __construct($id, $title, $content, $published, $status)
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setContent($content);
        $this->setPublished($published);
        $this->setStatus($status);
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
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param string $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
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

        $newsItems = [];
        foreach ($data as $news) {
            $newsItems[] = self::bindSqlResult($news);
        }

        return $newsItems;
    }

    /**
     * @param int $offset
     * @param int $amount
     * @return array
     */
    public static function getLimitedDescending($offset, $amount)
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `" . self::getTableName() . "` WHERE status = ? LIMIT ?,?",
            [
                self::STATUS_PUBLISHED,
                $offset,
                $amount
            ],
            'sii'
        );

        $newsItems = [];
        foreach ($data as $newsItem) {
            $newsItems[] = self::bindSqlResult($newsItem);
        }

        return $newsItems;
    }

    /**
     * @param array $data
     * @return News
     */
    private static function bindSqlResult($data)
    {
        return new News(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'title'),
            Util::arrayGet($data, 'content'),
            Util::arrayGet($data, 'published'),
            Util::arrayGet($data, 'status')
        );
    }

    /**
     * @param int $id
     * @return News
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
     *
     */
    public function save()
    {
        $db = \Lib\Core\Database::getInstance();
        $params = [
            $this->getTitle(),
            $this->getContent(),
            $this->getPublished(),
            $this->getStatus(),
        ];

        $types = 'ssss';
        if ($this->getId() === null || $this->getId() === 0) {
            $sql = "INSERT INTO `" . self::getTableName() . "` (`title`, `content`, `published`, `status`) VALUES ( ?, ?, ?, ? )";
        } else {
            $sql = "UPDATE `" . self::getTableName() . "` SET `title` = ?, `content` = ?, `published` = ?, `status` = ? WHERE `id` = ?";
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
        $result = Database::getInstance()->fetchOne("SELECT count(1) AS cnt FROM `" . self::getTableName() . "`");
        return Util::arrayGet($result, 'cnt', 0);
    }

    /**
     *
     */
    public function delete()
    {
        $result =  \Lib\Core\Database::getInstance()->query("DELETE FROM `" . self::getTableName() . "` WHERE id = ?", [$this->getId()], 'i');
        return $result->affected_rows > 0;
    }
}