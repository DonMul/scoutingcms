<?php

namespace Lib\Repository;

use \Lib\Core\Util;
use \Lib\Data;

/**
 * Class News
 * @package Lib\Repository
 */
final class News extends BaseRepository
{
    const TABLENAME = 'news';
    
    /**
     * @return string
     */
    private function getTableName() : string
    {
        return $this->getDatabase()->getFullTableName(self::TABLENAME);
    }

    /**
     * @return Data\News[]
     */
    public function getAll() : array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "`"
        );

        $newsItems = [];
        foreach ($data as $news) {
            $newsItems[] = $this->bindSqlResult($news);
        }

        return $newsItems;
    }

    /**
     * @param int $offset
     * @param int $amount
     * @return Data\News[]
     */
    public function getLimitedDescending(int $offset, int $amount) : array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE status = ? LIMIT ?,?",
            [
                Data\News::STATUS_PUBLISHED,
                $offset,
                $amount
            ],
            'sii'
        );

        $newsItems = [];
        foreach ($data as $newsItem) {
            $newsItems[] = $this->bindSqlResult($newsItem);
        }

        return $newsItems;
    }

    /**
     * @param array $data
     * @return Data\News
     */
    private function bindSqlResult($data) : ?Data\News
    {
        return new Data\News(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'title'),
            Util::arrayGet($data, 'content'),
            Util::arrayGet($data, 'published'),
            Util::arrayGet($data, 'status')
        );
    }

    /**
     * @param int $id
     * @return Data\News
     */
    public function getById(int $id) : ?Data\News
    {
        $data = $this->getDatabase()->fetchOne(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE id = ?",
            [$id],
            'i'
        );

        if ($data) {
            return $this->bindSqlResult($data);
        }

        return null;
    }

    /**
     * @param Data\News $news
     */
    public function save(Data\News $news)
    {
        $db = $this->getDatabase();
        $params = [
            $news->getTitle(),
            $news->getContent(),
            $news->getPublished(),
            $news->getStatus(),
        ];

        $types = 'ssss';
        if ($news->getId() === null || $news->getId() === 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "` (`title`, `content`, `published`, `status`) VALUES ( ?, ?, ?, ? )";
        } else {
            $sql = "UPDATE `" . $this->getTableName() . "` SET `title` = ?, `content` = ?, `published` = ?, `status` = ? WHERE `id` = ?";
            $params[] = $news->getId();
            $types .= 'i';
        }

        $result = $db->query($sql, $params, $types);
        $news->setId($result->insert_id);
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
     * @param Data\News $news
     * @return bool
     */
    public function delete(Data\News $news)
    {
        $result =  $this->getDatabase()->query("DELETE FROM `" . $this->getTableName() . "` WHERE id = ?", [$news->getId()], 'i');
        return $result->affected_rows > 0;
    }
}
