<?php

namespace Lib\Data;

/**
 * Class News
 * @package Lib\Data
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class News
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $published;

    /**
     * @var string
     */
    private $status;

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';

    /**
     * News constructor.
     * @param int $id
     * @param string $title
     * @param string $content
     * @param string $published
     * @param string $status
     */
    public function __construct(?int $id, string $title, string $content, string $published, string $status)
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setContent($content);
        $this->setPublished($published);
        $this->setStatus($status);
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

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getPublished(): string
    {
        return $this->published;
    }

    /**
     * @param string $published
     */
    public function setPublished(string $published)
    {
        $this->published = $published;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }
}
