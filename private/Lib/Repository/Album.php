<?php

namespace Lib\Repository;

use \Lib\Core\Util;
use \Lib\Data;

/**
 * Class Album
 * @package Lib\Repository
 */
final class Album extends BaseRepository
{
    const TABLENAME = 'album';

    /**
     * @return Data\Album[]
     */
    public function getAll() : array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "`"
        );

        $albums = [];
        foreach ($data as $album) {
            $albums[] = $this->bindSqlResult($album);
        }

        return $albums;
    }

    /**
     * @param int $category
     * @return Data\Album[]
     */
    public function findByCategory(int $category): array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE category = ?",
            [$category],
            'i'
        );

        $albums = [];
        foreach ($data as $album) {
            $albums[] = $this->bindSqlResult($album);
        }

        return $albums;
    }

    /**
     * @param int $category
     * @return Data\Album[]
     */
    public function findPublicByCategory(int $category): array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE category = ? AND private = ?",
            [$category, 0],
            'ii'
        );

        $albums = [];
        foreach ($data as $album) {
            $albums[] = $this->bindSqlResult($album);
        }

        return $albums;
    }

    /**
     * @param int $id
     * @return Data\Album
     */
    public function getById(int $id): ?Data\Album
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
     * @param string $category
     * @param string $slug
     * @return Data\Album
     */
    public function getByCategoryAndSlug(string $category, string $slug): ?Data\Album
    {
        $data = $this->getDatabase()->fetchOne(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE category = ? AND slug = ?",
            [$category, $slug],
            'ss'
        );

        if ($data) {
            return $this->bindSqlResult($data);
        }

        return null;
    }

    /**
     * @param array $data
     * @return Data\Album
     */
    private function bindSqlResult($data): ?Data\Album
    {
        return new Data\Album(
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
    public function save(Data\Album $album)
    {
        $db = $this->getDatabase();
        $params = [
            $album->getName(),
            $album->getSlug(),
            $album->getDescription(),
            $album->getCategory(),
            $album->getThumbnail(),
            intval($album->isPrivate()),
        ];

        $types = 'sssssi';
        if ($album->getId() === null || $album->getId() === 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "` (`name`, `slug`, `description`, `category`, `thumbnail`, `private`) VALUES ( ?, ?, ?, ?, ?, ? )";
        } else {
            $sql = "UPDATE `" . $this->getTableName() . "` SET `name` = ?, `slug` = ?, `description` = ?, `category` = ?, `thumbnail` = ?, `private` = ? WHERE `id` = ?";
            $params[] = $album->getId();
            $types .= 'i';
        }

        $result = $db->query($sql, $params, $types);
        $album->setId($result->insert_id);
    }

    /**
     * @param Data\Album $album
     * @return bool
     */
    public function delete(Data\Album $album): bool
    {
        $result = $this->getDatabase()->query("DELETE FROM `" . $this->getTableName() . "` WHERE id = ?", [$album->getId()], 'i');
        return $result->affected_rows > 0;
    }

    /**
     * @return int
     */
    public function getTotalAmount(): int
    {
        $result = $this->getDatabase()->fetchOne("SELECT count(1) AS cnt FROM `" . $this->getTableName() . "`");
        return Util::arrayGet($result, 'cnt', 0);
    }

    /**
     * @return string
     */
    private function getTableName(): string
    {
        return $this->getDatabase()->getFullTableName(self::TABLENAME);
    }
}
