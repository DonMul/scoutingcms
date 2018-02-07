<?php

namespace Unit\Controller;

use Controller\Index;

/**
 * Class IndexTest
 * @package Unit\Controller
 */
class IndexTest extends \PHPUnit\Framework\TestCase
{
    public function testGetArray()
    {
        $mockPage = new \Lib\Data\Page(0, 'Page', 'slug', 'content', 'header', false);
        $pageRepo = new \Lib\Repository\Page();
        $_GET['slug'] = $mockPage->getSlug();

        $pageDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $pageDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Page::TABLENAME))->will($this->returnValue(\Lib\Repository\Page::TABLENAME));
        $pageDatabase->method('fetchOne')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Page::TABLENAME . '` WHERE isHomepage = ? LIMIT 1'), $this->equalTo([1]), $this->equalTo('i'))->will($this->returnValue([
            'id' => $mockPage->getId(),
            'title' => $mockPage->getTitle(),
            'slug' => $mockPage->getSlug(),
            'content' => $mockPage->getContent(),
            'header' => $mockPage->getHeader(),
            'isHomepage' => intval($mockPage->isHomepage())
        ]));
        $pageRepo->setDatabase($pageDatabase);
        $controller = new Index();
        $controller->setPageRepository($pageRepo);

        $this->assertEquals($controller->getArray(), ['page' => $mockPage]);
    }

    public function testGetTitle()
    {
        $controller = new mockIndexController();
        $this->assertEquals($controller->testGetTitle(), \Lib\Core\Translation::getInstance()->translate("title.index"));
    }
}

final class mockIndexController extends Index
{
    public function testGetTitle()
    {
        return $this->getTitle();
    }
}
