<?php

namespace Lib\Repository;

use \Lib\Core\Util;
use \Lib\Data;

/**
 * Class AgendaCategory
 * @package Lib\Repository
 */
final class AgendaCategory extends BaseRepository
{
    const TABLENAME = 'agendaCategory';

    /**
     * @return string
     */
    private function getTableName()
    {
        return $this->getDatabase()->getFullTableName(self::TABLENAME);
    }

    /**
     * @return Data\AgendaCategory[]
     */
    public function getAll(): array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "`"
        );

        $agendaCategories = [];
        foreach ($data as $agendaCategory) {
            $agendaCategories[] = $this->bindSqlResult($agendaCategory);
        }

        return $agendaCategories;
    }

    /**
     * @param int $id
     * @return Data\AgendaCategory
     */
    public function getById(int $id): ?Data\AgendaCategory
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
     * @return Data\AgendaCategory
     */
    public function getByName(string $name): ?Data\AgendaCategory
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
     *
     */
    public function save(Data\AgendaCategory $category)
    {
        $params = [
            $category->getName(),
            $category->getColor(),
        ];

        $types = 'ss';
        if ($category->getId() === null || $category->getId() === 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "` (`name`, `color`) VALUES ( ?, ? )";
        } else {
            $sql = "UPDATE `" . $this->getTableName() . "` SET `name` = ?, `color` = ? WHERE `id` = ?";
            $params[] = $category->getId();
            $types .= 'i';
        }

        $result = $this->getDatabase()->query($sql, $params, $types);
        $category->setId($result->insert_id);
    }

    /**
     * @return bool
     */
    public function delete(Data\AgendaCategory $category): bool
    {
        $result = $this->getDatabase()->query("DELETE FROM `" . $this->getTableName() . "` WHERE id = ?", [$category->getId()], 'i');
        return $result->affected_rows > 0;
    }

    /**
     * @param array $data
     * @return Data\AgendaCategory
     */
    private static function bindSqlResult(array $data): Data\AgendaCategory
    {
        return new Data\AgendaCategory(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'name'),
            Util::arrayGet($data, 'color')
        );
    }
}
