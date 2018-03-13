<?php

namespace Lib\Repository;

use \Lib\Core\Util;
use \Lib\Data;

/**
 * Class Data\Speltak
 * @package Lib\Repository
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Speltak extends BaseRepository
{
    const TABLENAME = 'group';
    
    /**
     * @return string
     */
    private function getTableName() : string
    {
        return $this->getDatabase()->getFullTableName(self::TABLENAME);
    }

    /**
     * @return Data\Speltak[]
     */
    public function getAll() : array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "`"
        );

        $speltakken = [];
        foreach ($data as $speltak) {
            $speltakken[] = $this->bindSqlResult($speltak);
        }

        return $speltakken;
    }

    /**
     * @param int $id
     * @return Data\Speltak
     */
    public function getById(int $id) : ?Data\Speltak
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
     * @param string $name
     * @return Data\Speltak
     */
    public function getByName(string $name) : ?Data\Speltak
    {
        $data = $this->getDatabase()->fetchOne(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE name = ?",
            [$name],
            's'
        );

        if (!$data) {
            return null;
        }

        return $this->bindSqlResult($data);
    }

    /**
     * @param array $data
     * @return Data\Speltak
     */
    private function bindSqlResult(array $data) : Data\Speltak
    {
        return new Data\Speltak(
            $data['id'],
            $data['name'],
            $data['picture'],
            $data['description']
        );
    }

    /**
     * @param Data\Speltak $speltak
     */
    public function save(Data\Speltak $speltak)
    {
        $db = $this->getDatabase();
        $params = [
            $speltak->getName(),
            $speltak->getDescription(),
            $speltak->getPicture()
        ];

        $types = 'sss';
        if ($speltak->getId() === null || $speltak->getId() === 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "` (`name`, `description`, `picture`) VALUES ( ?, ?, ? )";
        } else {
            $sql = "UPDATE `" . $this->getTableName() . "` SET `name` = ?, `description` = ?, `picture` = ? WHERE `id` = ?";
            $params[] = $speltak->getId();
            $types .= 'i';
        }

        $result = $db->query($sql, $params, $types);
        $speltak->setId($result->insert_id);
    }

    /**
     * @return int
     */
    public function getTotalAmount() : int
    {
        $result = $this->getDatabase()->fetchOne("SELECT COUNT(1) AS cnt FROM `" . $this->getTableName() . "`");
        return Util::arrayGet($result, 'cnt', 0);
    }
}
