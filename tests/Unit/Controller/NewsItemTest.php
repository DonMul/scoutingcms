<?php

namespace Unit\Controller;

use Controller\NewsItem;
use Lib\Data\News;

/**
 * Class NewsItemTest
 * @package Unit\Controller
 */
class NewsItemTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testNewsItemHappyFlow()
    {
        $controller = new NewsItem();

        $mockNewsItem = new News(7, 'title', 'content', '2018-01-01', News::STATUS_PUBLISHED);
        $newsRepo = new \Lib\Repository\News();
        $_GET['id'] = $mockNewsItem->getId();

        $newsItemDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $newsItemDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\News::TABLENAME))->will($this->returnValue(\Lib\Repository\News::TABLENAME));
        $newsItemDatabase->method('fetchOne')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\News::TABLENAME . '` WHERE id = ?'), $this->equalTo([$mockNewsItem->getId()]), $this->equalTo('i'))->will($this->returnValue([
            'id' => $mockNewsItem->getId(),
            'title' => $mockNewsItem->getTitle(),
            'content' => $mockNewsItem->getContent(),
            'published' => $mockNewsItem->getPublished(),
            'status' => $mockNewsItem->getStatus(),
        ]));
        $newsRepo->setDatabase($newsItemDatabase);
        $controller->setNewsRepository($newsRepo);

        $this->assertEquals($controller->getArray(), ['article' => $mockNewsItem]);
    }

    /**
     * @expectedException \Lib\Exception\PageNotFound
     */
    public function testPagePageNotFound()
    {
        $controller = new NewsItem();

        $mockNewsItem = new News(7, 'title', 'content', '2018-01-01', News::STATUS_PUBLISHED);
        $newsRepo = new \Lib\Repository\News();
        $_GET['id'] = $mockNewsItem->getId();

        $newsItemDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $newsItemDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\News::TABLENAME))->will($this->returnValue(\Lib\Repository\News::TABLENAME));
        $newsItemDatabase->method('fetchOne')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\News::TABLENAME . '` WHERE id = ?'), $this->equalTo([$mockNewsItem->getId()]), $this->equalTo('i'))->will($this->returnValue(null));
        $newsRepo->setDatabase($newsItemDatabase);
        $controller->setNewsRepository($newsRepo);

        $controller->getArray();
    }
}
