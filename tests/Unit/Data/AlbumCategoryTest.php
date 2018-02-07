<?php

namespace Unit\Data;

/**
 * Class AlbumCategoryTest
 */
class AlbumCategoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testCreateAlbumCategory()
    {
        $id = rand(0, 1000);
        $name = 'Test Album Category';
        $agendaCategory = new \Lib\Data\AlbumCategory($id, $name);

        $this->assertEquals($agendaCategory->getId(), $id);
        $this->assertEquals($agendaCategory->getName(), $name);
    }
}
