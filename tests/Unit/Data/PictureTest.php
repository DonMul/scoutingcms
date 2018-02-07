<?php

namespace Unit\Data;

/**
 * Class PictureTest
 */
class PictureTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testCreatePicture()
    {
        $id = rand(0, 1000);
        $albumId = rand(0, 1000);
        $location = '/test/file.png';
        $title = 'Test Picture Title';
        $picture = new \Lib\Data\Picture($id, $albumId, $location, $title);

        $this->assertEquals($picture->getId(), $id);
        $this->assertEquals($picture->getAlbumId(), $albumId);
        $this->assertEquals($picture->getLocation(), $location);
        $this->assertEquals($picture->getTitle(), $title);
    }
}
