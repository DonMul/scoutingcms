<?php

namespace Unit\Controller;

use Controller\Page;

/**
 * Class PageTest
 * @package Unit\Controller
 */
class PageTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testPageHappyFlow()
    {
        $controller = new Page();

        $mockPage = new \Lib\Data\Page(0, 'Page', 'slug', 'content', 'header', false);
        $pageRepo = new \Lib\Repository\Page();
        $_GET['slug'] = $mockPage->getSlug();

        $pageDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $pageDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Page::TABLENAME))->will($this->returnValue(\Lib\Repository\Page::TABLENAME));
        $pageDatabase->method('fetchOne')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Page::TABLENAME . '` WHERE slug = ?'), $this->equalTo([$mockPage->getSlug()]), $this->equalTo('s'))->will($this->returnValue([
                'id' => $mockPage->getId(),
                'title' => $mockPage->getTitle(),
                'slug' => $mockPage->getSlug(),
                'content' => $mockPage->getContent(),
                'header' => $mockPage->getHeader(),
                'isHomepage' => intval($mockPage->isHomepage())
        ]));
        $pageRepo->setDatabase($pageDatabase);
        $controller->setPageRepository($pageRepo);

        $this->assertEquals($controller->getArray(), ['page' => $mockPage]);
    }

    /**
     * @expectedException \Lib\Exception\PageNotFound
     */
    public function testPagePageNotFound()
    {
        $controller = new Page();

        $pageRepo = new \Lib\Repository\Page();
        $_GET['slug'] = 'slug';

        $pageDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $pageDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Page::TABLENAME))->will($this->returnValue(\Lib\Repository\Page::TABLENAME));
        $pageDatabase->method('fetchOne')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Page::TABLENAME . '` WHERE slug = ?'), $this->equalTo(['slug']), $this->equalTo('s'))->will($this->returnValue(null));
        $pageRepo->setDatabase($pageDatabase);
        $controller->setPageRepository($pageRepo);

        $controller->getArray();
    }
}
