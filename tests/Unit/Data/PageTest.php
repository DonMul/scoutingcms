<?php

namespace Unit\Data;

/**
 * Class PageTest
 */
class PageTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testCreatePage()
    {
        $id = rand(0, 1000);
        $title = 'Test Page Title';
        $slug = 'test-page-slug';
        $content = 'Test Page Content';
        $header = 'Test Page Header';
        $isHomepage = false;
        $page = new \Lib\Data\Page($id, $title, $slug, $content, $header, $isHomepage);

        $this->assertEquals($page->getId(), $id);
        $this->assertEquals($page->getTitle(), $title);
        $this->assertEquals($page->getSlug(), $slug);
        $this->assertEquals($page->getContent(), $content);
        $this->assertEquals($page->getHeader(), $header);
        $this->assertEquals($page->isHomepage(), $isHomepage);
    }
}
