<?php

namespace Unit\Controller;

use Lib\Data\News;

/**
 * Class NewsTest
 * @package Unit\Controller
 */
class NewsTest extends \PHPUnit\Framework\TestCase
{
    public function testGetArray()
    {
        $from = rand(0,1000);
        $to = rand($from, 1000);

        $_GET['offset'] = $from;
        $_GET['amount'] = $to;
        $mockNewsItem = new News(rand($from, $to), 'title', 'content', '2018-01-01', News::STATUS_PUBLISHED);
        $newsRepo = new \Lib\Repository\News();
        $newsDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $newsDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\News::TABLENAME))->will($this->returnValue(\Lib\Repository\News::TABLENAME));
        $newsDatabase->method('fetchAll')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\News::TABLENAME . '` WHERE status = ? LIMIT ?,?'), $this->equalTo([News::STATUS_PUBLISHED, $from, $to]), $this->equalTo('sii'))->will($this->returnValue([
            [
                'id' => $mockNewsItem->getId(),
                'title' => $mockNewsItem->getTitle(),
                'content' => $mockNewsItem->getContent(),
                'published' => $mockNewsItem->getPublished(),
                'status' => $mockNewsItem->getStatus(),
            ]
        ]));

        $newsDatabase->method('fetchOne')->with($this->equalTo("SELECT COUNT(1) AS cnt FROM `" . \Lib\Repository\News::TABLENAME  . "`"))->will($this->returnValue(['cnt' => 1]));
        $newsRepo->setDatabase($newsDatabase);
        $controller = new \Controller\News();
        $controller->setNewsRepository($newsRepo);

        $result = $controller->getArray();
        $this->assertEquals($result, [
            'articles' => [$mockNewsItem],
            'total' => 1
        ]);
    }
}
