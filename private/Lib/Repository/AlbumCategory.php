<?php

namespace Lib\Repository;

use Lib\Core\Util;
use Lib\Data;

/**
 * Class Data\AlbumCategory
 * @package Lib\Repository
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class AlbumCategory extends BaseRepository
{
    const TABLENAME = 'albumCategory';

    /**
     * @return string
     */
    private function getTableName()
    {
        return $this->getDatabase()->getFullTableName(self::TABLENAME);
    }

    /**
     * @return Data\AlbumCategory[]
     */
    public function getAll() : array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "`"
        );

        $albumCategories = [];
        foreach ($data as $albumCategory) {
            $albumCategories[] = $this->bindSqlResult($albumCategory);
        }

        return $albumCategories;
    }

    /**
     * @param int $id
     * @return Data\AlbumCategory
     */
    public function getById(int $id) : ?Data\AlbumCategory
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
     * @param string $name
     * @return Data\AlbumCategory
     */
    public function getByName(string $name) : ?Data\AlbumCategory
    {
        $data = $this->getDatabase()->fetchOne(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE `name` = ?",
            [$name],
            's'
        );

        if ($data) {
            return $this->bindSqlResult($data);
        }

        return null;
    }

    /**
     * @param array $data
     * @return Data\AlbumCategory
     */
    private function bindSqlResult(array $data) : ?Data\AlbumCategory
    {
        return new Data\AlbumCategory(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'name')
        );
    }

    /**
     *
     */
    public function save(Data\AlbumCategory $category)
    {
        $db = $this->getDatabase();
        $params = [
            $category->getName(),
        ];

        $types = 's';
        if ($category->getId() === null || $category->getId() === 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "` (`name`) VALUES ( ? )";
        } else {
            $sql = "UPDATE `" . $this->getTableName() . "` SET `name` = ? WHERE `id` = ?";
            $params[] = $category->getId();
            $types .= 'i';
        }

        $result = $db->query($sql, $params, $types);
        $category->setId($result->insert_id);
    }

    /**
     * @return bool
     */
    public function delete(Data\AlbumCategory $category) : bool
    {
        $result =  $this->getDatabase()->query("DELETE FROM `" . $this->getTableName() . "` WHERE id = ?", [$category->getId()], 'i');
        return $result->affected_rows > 0;
    }
}
