<?php

namespace Lib\Repository;

use Lib\Core\Util;
use Lib\Data;

/**
 * Class Data\Picture
 * @package Lib\Repository
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Picture extends BaseRepository
{
    const TABLENAME = 'picture';


    /**
     * @return string
     */
    private function getTableName()
    {
        return $this->getDatabase()->getFullTableName(self::TABLENAME);
    }

    /**
     * @return Data\Picture[]
     */
    public function getAll(): array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "`"
        );

        $pictures = [];
        foreach ($data as $picture) {
            $pictures[] = $this->bindSqlResult($picture);
        }

        return $pictures;
    }

    /**
     * @param int $albumId
     * @return Data\Picture[]
     */
    public function findByAlbumId(int $albumId): array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE albumId = ?",
            [$albumId],
            'i'
        );

        $pictures = [];
        foreach ($data as $picture) {
            $pictures[] = $this->bindSqlResult($picture);
        }

        return $pictures;
    }

    /**
     * @param array $data
     * @return Data\Picture
     */
    private function bindSqlResult(array $data): Data\Picture
    {
        return new Data\Picture(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'albumId'),
            Util::arrayGet($data, 'location'),
            Util::arrayGet($data, 'title')
        );
    }

    /**
     * @param Data\Picture $picture
     */
    public function save(Data\Picture $picture)
    {
        $db = $this->getDatabase();
        $params = [
            $picture->getAlbumId(),
            $picture->getLocation(),
            $picture->getTitle(),
        ];

        $types = 'iss';
        if ($picture->getId() === null || $picture->getId() === 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "` (`albumId`, `location`, `title`) VALUES ( ?, ?, ? )";
        } else {
            $sql = "UPDATE `" . $this->getTableName() . "` SET `albumId` = ?, `location` = ?, `title` = ? WHERE `id` = ?";
            $params[] = $picture->getId();
            $types .= 'i';
        }

        $result = $db->query($sql, $params, $types);
        $picture->setId($result->insert_id);
    }

    /**
     * @return int
     */
    public function getTotalAmount(): int
    {
        $result = $this->getDatabase()->fetchOne("SELECT COUNT(1) AS cnt FROM `" . $this->getTableName() . "`");
        return Util::arrayGet($result, 'cnt', 0);
    }

    /**
     * @param int $id
     * @return Data\Picture
     */
    public function getById(int $id): ?Data\Picture
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
     * @param Data\Picture $picture
     * @return bool
     */
    public function delete(Data\Picture $picture): bool
    {
        $result = $this->getDatabase()->query("DELETE FROM `" . $this->getTableName() . "` WHERE id = ?", [$picture->getId()], 'i');
        return $result->affected_rows > 0;
    }
}
