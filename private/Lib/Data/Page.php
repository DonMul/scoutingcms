<?php

namespace Lib\Data;

use Lib\Core\Database;
use Lib\Core\Util;

/**
 * Class Page
 * @package Lib\Data
 */
final class Page
{
    const TABLENAME = 'page';

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
    private $slug;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $header;

    /**
     * @var bool
     */
    private $isHomepage;

    /**
     * Page constructor.
     * @param int $id
     * @param string $title
     * @param string $slug
     * @param string $content
     */
    public function __construct($id, $title, $slug, $content, $header, $isHomepage)
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setSlug($slug);
        $this->setContent($content);
        $this->setHeader($header);
        $this->setIsHomepage($isHomepage);
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
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param string $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return bool
     */
    public function isHomepage()
    {
        return $this->isHomepage;
    }

    /**
     * @param bool $isHomepage
     */
    public function setIsHomepage($isHomepage)
    {
        $this->isHomepage = $isHomepage;
    }

    /**
     * @return string
     */
    private static function getTableName()
    {
        return Database::getInstance()->getFullTableName(self::TABLENAME);
    }

    /**
     * @param string $slug
     * @return Page
     */
    public static function getBySlug($slug)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `" . self::getTableName() . "` WHERE slug = ?",
            [$slug],
            's'
        );

        if (!$data) {
            return null;
        }

        return self::bindSqlResult($data);
    }

    /**
     * @param string $id
     * @return Page
     */
    public static function getById($id)
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `" . self::getTableName() . "` WHERE id = ?",
            [$id],
            'i'
        );

        if (!$data) {
            return null;
        }

        return self::bindSqlResult($data);
    }

    /**
     * @return Page
     */
    public static function getHomepage()
    {
        $data = \Lib\Core\Database::getInstance()->fetchOne(
            "SELECT * FROM `" . self::getTableName() . "` WHERE isHomepage = ? LIMIT 1",
            [1],
            'i'
        );

        if (!$data) {
            return null;
        }

        return self::bindSqlResult($data);
    }

    /**
     * @return Page[]
     */
    public static function getAll()
    {
        $data = \Lib\Core\Database::getInstance()->fetchAll(
            "SELECT * FROM `" . self::getTableName() . "`"
        );

        $pages = [];
        foreach ($data as $page) {
            $pages[] = self::bindSqlResult($page);
        }

        return $pages;
    }

    /**
     * @param $data
     * @return Page
     */
    private static function bindSqlResult($data)
    {
        return new Page(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'title'),
            Util::arrayGet($data, 'slug'),
            Util::arrayGet($data, 'content'),
            Util::arrayGet($data, 'header'),
            Util::arrayGet($data, 'isHomepage')
        );
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

    /**
     *
     */
    public function save()
    {
        $db = \Lib\Core\Database::getInstance();
        $params = [
            $this->getTitle(),
            $this->getSlug(),
            $this->getContent(),
            $this->getHeader(),
            intval($this->isHomepage()),
        ];

        $types = 'ssssi';
        if ($this->getId() === null || $this->getId() === 0) {
            $sql = "INSERT INTO `" . self::getTableName() . "` (`title`, `slug`, `content`, `header`, `isHomepage`) VALUES ( ?, ?, ?, ?, ? )";
        } else {
            $sql = "UPDATE `" . self::getTableName() . "` SET `title` = ?, `slug` = ?, `content` = ?, `header` = ?, `isHomepage` = ? WHERE `id` = ?";
            $params[] = $this->getId();
            $types .= 'i';
        }

        $result = $db->query($sql, $params, $types);
        $this->setId($result->insert_id);
    }
}