<?php

namespace Lib\Repository;

use \Lib\Core\Util;
use \Lib\Data;

/**
 * Class Agenda
 * @package Lib\Repository
 */
final class Agenda extends BaseRepository
{
    const TABLENAME = 'agenda';

    /**
     * @return string
     */
    private function getTableName()
    {
        return $this->getDatabase()->getFullTableName(self::TABLENAME);
    }

    /**
     * @return Data\Agenda[]
     */
    public function getAll(): array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "`"
        );

        $agendaItems = [];
        foreach ($data as $agendaItem) {
            $agendaItems[] = $this->bindSqlResult($agendaItem);
        }

        return $agendaItems;
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param bool $reverseOrder
     * @return Data\Agenda[]
     */
    public function findBetweenDates(string $startDate, string $endDate, bool $reverseOrder = false): array
    {
        $query = "SELECT * FROM `" . $this->getTableName() . "` WHERE startDate > ? AND endDate < ?";
        if ($reverseOrder) {
            $query .= " ORDER BY startDate DESC";
        }

        $data = $this->getDatabase()->fetchAll($query, [$startDate, $endDate], 'ss');

        $agendaItems = [];
        foreach ($data as $agendaItem) {
            $agendaItems[] = $this->bindSqlResult($agendaItem);
        }

        return $agendaItems;
    }

    /**
     * @param int $id
     * @return Data\Agenda
     */
    public function getById(int $id): ?Data\Agenda
    {
        $data = $this->getDatabase()->fetchOne(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE id = ?",
            [
                $id
            ],
            'i'
        );

        if ($data) {
            return $this->bindSqlResult($data);
        }

        return null;
    }

    /**
     * @param string $slug
     * @return Data\Agenda
     */
    public function getBySlug(string $slug): ?Data\Agenda
    {
        $data = $this->getDatabase()->fetchOne(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE slug = ?",
            [
                $slug
            ],
            's'
        );

        if ($data) {
            return $this->bindSqlResult($data);
        }

        return null;
    }

    public function save(Data\Agenda $agenda)
    {
        $params = [
            $agenda->getName(),
            $agenda->getStartDate(),
            $agenda->getEndDate(),
            $agenda->getDescription(),
            $agenda->getSlug(),
            $agenda->getCategory(),
        ];

        $types = 'ssssss';
        if ($agenda->getId() === null || $agenda->getId() === 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "` (`name`, `startDate`, `endDate`, `description`, `slug`, `category`) VALUES ( ?, ?, ?, ?, ?, ? )";
        } else {
            $sql = "UPDATE `" . $this->getTableName() . "` SET `name` = ?, `startDate` = ?, `endDate` = ?, `description` = ?, `slug` = ?, `category` = ? WHERE `id` = ?";
            $params[] = $agenda->getId();
            $types .= 'i';
        }

        $result = $this->getDatabase()->query($sql, $params, $types);
        $agenda->setId($result->insert_id);
    }

    /**
     * @param Data\Agenda $agenda
     * @return bool
     */
    public function delete(Data\Agenda $agenda): bool
    {
        $result = $this->getDatabase()->query("DELETE FROM `" . $this->getTableName() . "` WHERE id = ?", [$agenda->getId()], 'i');
        return $result->affected_rows > 0;
    }

    /**
     * @return int
     */
    public function getTotalAmount()
    {
        $result = $this->getDatabase()->fetchOne("SELECT count(1) AS cnt FROM `" . $this->getTableName() . "`");
        return Util::arrayGet($result, 'cnt', 0);
    }

    /**
     * @param array $data
     * @return Data\Agenda
     */
    private function bindSqlResult(array $data)
    {
        return new Data\Agenda(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'name'),
            Util::arrayGet($data, 'startDate'),
            Util::arrayGet($data, 'endDate'),
            Util::arrayGet($data, 'description'),
            Util::arrayGet($data, 'slug'),
            Util::arrayGet($data, 'category')
        );
    }
}
