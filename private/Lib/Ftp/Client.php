<?php

namespace Lib\Ftp;

/**
 * Class Client
 * @package Lib\Core\Ftp
 */
final class Client
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $host;

    /**
     * @var resource
     */
    private $connection;

    /**
     * Client constructor.
     * @param string $host
     * @param string $username
     * @param string $password
     */
    public function __construct($host, $username, $password)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return resource
     */
    private function getConnection()
    {
        if ($this->connection !== null) {
            return $this->connection;
        }

        $this->connection = ftp_connect($this->host);
        ftp_login($this->connection, $this->username, $this->password);
        ftp_pasv($this->connection, true);
        return $this->connection;
    }

    /**
     * @param string $localFile
     * @param string $remoteFile
     * @throws \Exception
     */
    public function upload($localFile, $remoteFile)
    {
        ftp_chdir($this->getConnection(), '/');
        $exploded = explode('/', $remoteFile);
        $file = array_pop($exploded);

        foreach ($exploded as $dir) {
            if (!@ftp_chdir($this->getConnection(), $dir)) {
                ftp_mkdir($this->getConnection(), $dir);
            }

            ftp_chdir($this->getConnection(), $dir);
        }

        $success = ftp_put($this->getConnection(), $file, $localFile, FTP_ASCII);
        if (!$success) {
            throw new \Exception("Error during uploading file via FTP");
        }
    }
}