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
     * @param int $id
     * @param string $title
     * @param string $slug
     * @param string $content
     */
    public function __construct($id, $title, $slug, $content, $header, $isHomepage)
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

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param string $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return bool
     */
    public function isHomepage()
    {
        return $this->isHomepage;
    }

    /**
     * @param bool $isHomepage
     */
    public function setIsHomepage($isHomepage)
    {
        $this->isHomepage = $isHomepage;
    }
}
