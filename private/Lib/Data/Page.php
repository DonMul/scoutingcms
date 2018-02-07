<?php

namespace Lib\Data;

use Lib\Core\Database;
use Lib\Core\Util;

/**
 * Class Page
 * @package Lib\Data
 */
final class Page
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
    private $slug;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $header;

    /**
     * @var bool
     */
    private $isHomepage;

    /**
     * Page constructor.
     * @param int|null $id
     * @param string $title
     * @param string $slug
     * @param string $content
     * @param string $header
     * @param bool $isHomepage
     */
    public function __construct(?int $id, string $title, string $slug, string $content, string $header, bool $isHomepage)
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setSlug($slug);
        $this->setContent($content);
        $this->setHeader($header);
        $this->setIsHomepage($isHomepage);
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
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
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
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @param string $header
     */
    public function setHeader(string $header)
    {
        $this->header = $header;
    }

    /**
     * @return bool
     */
    public function isHomepage(): bool
    {
        return $this->isHomepage;
    }

    /**
     * @param bool $isHomepage
     */
    public function setIsHomepage(bool $isHomepage)
    {
        $this->isHomepage = $isHomepage;
    }
}
