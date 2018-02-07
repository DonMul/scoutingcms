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
    public function __construct(?int $id, int $albumId, string $location, string $title)
    {
        $this->setId($id);
        $this->setAlbumId($albumId);
        $this->setLocation($location);
        $this->setTitle($title);
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getAlbumId(): int
    {
        return $this->albumId;
    }

    /**
     * @param int $albumId
     */
    public function setAlbumId(int $albumId)
    {
        $this->albumId = $albumId;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }
}
