<?php

namespace Lib\Repository;

use \Lib\Core\Util;
use \Lib\Data;

/**
 * Class Download
 * @package Lib\Repository
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Download extends BaseRepository
{
    const TABLENAME = 'download';

    /**
     * @return string
     */
    private function getTableName()
    {
        return $this->getDatabase()->getFullTableName(self::TABLENAME);
    }

    /**
     * @return Data\Download[]
     */
    public function getAll() : array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "`"
        );

        $downloads = [];
        foreach ($data as $download) {
            $downloads[] = $this->bindSqlResult($download);
        }

        return $downloads;
    }

    /**
     * @param array $data
     * @return Data\Download
     */
    private function bindSqlResult(array $data) : ?Data\Download
    {
        return new Data\Download(
            Util::arrayGet($data, 'id'),
            Util::arrayGet($data, 'name'),
            Util::arrayGet($data, 'type'),
            Util::arrayGet($data, 'filename')
        );
    }

    /**
     * @param int $id
     * @return Data\Download
     */
    public function getById(int $id) : ?Data\Download
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
     *
     */
    public function save(Data\Download $download)
    {
        $db = $this->getDatabase();
        $params = [
            $download->getName(),
            $download->getType(),
            $download->getFilename(),
        ];

        $types = 'sss';
        if ($download->getId() === null || $download->getId() === 0) {
            $sql = "INSERT INTO `" . $this->getTableName() . "` (`name`, `type`, `filename`) VALUES ( ?, ?, ? )";
        } else {
            $sql = "UPDATE `" . $this->getTableName() . "` SET `name` = ?, `type` = ?, `filename` = ? WHERE `id` = ?";
            $params[] = $download->getId();
            $types .= 'i';
        }

        $result = $db->query($sql, $params, $types);
        $download->setId($result->insert_id);
    }

    /**
     * @param string $type
     * @return Data\Download[]
     */
    public function findByType(string $type) : array
    {
        $data = $this->getDatabase()->fetchAll(
            "SELECT * FROM `" . $this->getTableName() . "` WHERE type = ? ORDER BY id DESC",
            [$type],
            's'
        );

        $downloads = [];
        foreach ($data as $download) {
            $downloads[] = $this->bindSqlResult($download);
        }

        return $downloads;
    }

    /**
     * @param Data\Download $download
     * @return bool
     */
    public function delete(Data\Download $download) : bool
    {
        $result =  $this->getDatabase()->query("DELETE FROM `" . $this->getTableName() . "` WHERE id = ?", [$download->getId()], 'i');
        return $result->affected_rows > 0;
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
