<?php

namespace Unit\Data;

/**
 * Class NewsTest
 */
class NewsTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testCreateNews()
    {
        $id = rand(0, 1000);
        $title = 'Test News';
        $content = 'Test Content';
        $published = date('Y-m-d');
        $status = \Lib\Data\News::STATUS_PUBLISHED;
        $news = new \Lib\Data\News($id, $title, $content, $published, $status);

        $this->assertEquals($news->getId(), $id);
        $this->assertEquals($news->getTitle(), $title);
        $this->assertEquals($news->getContent(), $content);
        $this->assertEquals($news->getPublished(), $published);
        $this->assertEquals($news->getStatus(), $status);
    }
}
