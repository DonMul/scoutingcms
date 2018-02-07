<?php

namespace Unit\Data;

/**
 * Class AlbumTest
 */
class AlbumTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testCreateAlbum()
    {
        $id = rand(0,1000);
        $name = 'Test Album';
        $slug = 'test-album';
        $description = 'Test Description';
        $category = rand(0,1000);
        $thumbnail = 'thumb.jpg';
        $private = true;

        $album = new \Lib\Data\Album($id, $name, $slug, $description, $category, $thumbnail, $private);

        $this->assertEquals($album->getId(), $id);
        $this->assertEquals($album->getName(), $name);
        $this->assertEquals($album->getSlug(), $slug);
        $this->assertEquals($album->getDescription(), $description);
        $this->assertEquals($album->getCategory(), $category);
        $this->assertEquals($album->getThumbnail(), $thumbnail);
        $this->assertEquals($album->isPrivate(), $private);
    }
}
