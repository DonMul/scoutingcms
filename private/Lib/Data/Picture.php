<?php

namespace Lib\Data;
use Lib\Core\Database;
use Lib\Core\Util;

/**
 * Class Picture
 * @package Lib\Data
 */
final class Picture
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $albumId;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $title;

    /**
     * Picture constructor.
     * @param int $id
     * @param int $albumId
     * @param string $location
     * @param string $title
     */
    public function __construct($id, $albumId, $location, $title)
    {
        $this->setId($id);
        $this->setAlbumId($albumId);
        $this->setLocation($location);
        $this->setTitle($title);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getAlbumId()
    {
        return $this->albumId;
    }

    /**
     * @param int $albumId
     */
    public function setAlbumId($albumId)
    {
        $this->albumId = $albumId;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
