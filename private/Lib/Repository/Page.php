<?php

namespace Lib\Repository;

use \Lib\Core\Util;
use \Lib\Data;

/**
 * Class Data\Page
 * @package Lib\Repository
 */
final class Page extends BaseRepository
{
    const TABLENAME = 'page';

    /**
     * @return string
     */
    private function getTableName() : string
    {
        return $this->getDatabase()->getFullTableName(self::TABLENAME);
    }

    /**
     * @param string $slug
     * @return Data\Page
     */
    public function getBySlug(string $slug) : ?Data\Page
    {
        $data = $this->getDatabase()->fetchOne(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE slug = ?",
            [$slug],
            's'
        );

        if (!$data) {
            return null;
        }

        return $this->bindSqlResult($data);
    }

    /**
     * @param string $id
     * @return Data\Page
     */
    public function getById($id)
    {
        $data = $this->getDatabase()->fetchOne(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE id = ?",
            [$id],
            'i'
        );

        if (!$data) {
            return null;
        }

        return $this->bindSqlResult($data);
    }

    /**
     * @return Data\Page
     */
    public function getHomepage() : ?Data\Page
    {
        $data = $this->getDatabase()->fetchOne(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE isHomepage = ? LIMIT 1",
            [1],
            'i'
        );

        if (!$data) {
            return null;
        }

        return $this->bindSqlResult($data);
    }

    /**
     * @return Data\Page[]
     */
    public function getAll() : array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "`"
        );

        $pages = [];
        foreach ($data as $page) {
            $pages[] = $this->bindSqlResult($page);
        }

        return $pages;
    }

    /**
     * @param array $data
     * @return Data\Page
     */
    private function bindSqlResult(array $data) : ?Data\Page
    {
        return new Data\Page(
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
    public function getTotalAmount() : int
    {
        $result = $this->getDatabase()->fetchOne("SELECT COUNT(1) AS cnt FROM `" . $this->getTableName() . "`");
        return Util::arrayGet($result, 'cnt', 0);
    }

    /**
     * @param Data\Page $page
     * @return bool
     */
    public function delete(Data\Page $page) : bool
    {
        $result =  $this->getDatabase()->query("DELETE FROM `" . $this->getTableName() . "` WHERE id = ?", [$page->getId()], 'i');
        return $result->affected_rows > 0;
    }

    /**
     * @param Data\Page $page
     */
    public function save(Data\Page $page)
    {
        $db = $this->getDatabase();
        $params = [
            $page->getTitle(),
            $page->getSlug(),
            $page->getContent(),
            $page->getHeader(),
            intval($page->isHomepage()),
        ];

        $types = 'ssssi';
        if ($page->getId() === null || $page->getId() === 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "` (`title`, `slug`, `content`, `header`, `isHomepage`) VALUES ( ?, ?, ?, ?, ? )";
        } else {
            $sql = "UPDATE `" . $this->getTableName() . "` SET `title` = ?, `slug` = ?, `content` = ?, `header` = ?, `isHomepage` = ? WHERE `id` = ?";
            $params[] = $page->getId();
            $types .= 'i';
        }

        $result = $db->query($sql, $params, $types);
        $page->setId($result->insert_id);
    }
}
