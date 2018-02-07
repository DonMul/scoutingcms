<?php

namespace Unit\Controller;

use Controller\Albums;
use Lib\Data\Album;
use Lib\Data\AlbumCategory;

/**
 * Class AlbumsTest
 * @package Unit\Controller
 */
class AlbumsTest extends \PHPUnit\Framework\TestCase
{
    public function testGetArrayHappyFlow()
    {
        $mockAlbumCategory = new AlbumCategory(2, 'name');
        $mockAlbum = new Album(3, 'name', 'slug', 'description', $mockAlbumCategory->getId(), 'thumb', false);

        $_GET['category'] = $mockAlbumCategory->getName();
        $albumCatergoryRepo = new \Lib\Repository\AlbumCategory();
        $albumCatergoryDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $albumCatergoryDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\AlbumCategory::TABLENAME))->will($this->returnValue(\Lib\Repository\AlbumCategory::TABLENAME));
        $albumCatergoryDatabase->method('fetchAll')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\AlbumCategory::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue([
            [
                'id' => $mockAlbumCategory->getId(),
                'name' => $mockAlbumCategory->getName(),
            ]
        ]));
        $albumCatergoryDatabase->method('fetchOne')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\AlbumCategory::TABLENAME . '` WHERE `name` = ?'), $this->equalTo([$mockAlbumCategory->getName()]), $this->equalTo('s'))->will($this->returnValue([
            'id' => $mockAlbumCategory->getId(),
            'name' => $mockAlbumCategory->getName(),
        ]));
        $albumCatergoryRepo->setDatabase($albumCatergoryDatabase);

        $albumRepo = new \Lib\Repository\Album();
        $albumDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $albumDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Album::TABLENAME))->will($this->returnValue(\Lib\Repository\Album::TABLENAME));
        $albumDatabase->method('fetchAll')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Album::TABLENAME . '` WHERE category = ? AND private = ?'), $this->equalTo([$mockAlbumCategory->getId(), 0]), $this->equalTo('ii'))->will($this->returnValue([
            [
                'id' => $mockAlbum->getId(),
                'name' => $mockAlbum->getName(),
                'slug' => $mockAlbum->getSlug(),
                'description' => $mockAlbum->getDescription(),
                'category' => $mockAlbum->getCategory(),
                'thumbnail' => $mockAlbum->getThumbnail(),
                'private' => intval($mockAlbum->isPrivate())
            ]
        ]));
        $albumRepo->setDatabase($albumDatabase);

        $controller = new Albums();
        $controller->setAlbumCategoryRepository($albumCatergoryRepo);
        $controller->setAlbumRepository($albumRepo);
        $result = $controller->getArray();

        $this->assertEquals($result, [
            'albums' => [$mockAlbum],
            'categories' => [$mockAlbumCategory]
        ]);
    }

    /**
     * @expectedException \Lib\Exception\PageNotFound
     */
    public function testGetArrayCategoryNotFound()
    {
        $mockAlbumCategory = new AlbumCategory(2, 'name');
        $mockAlbum = new Album(3, 'name', 'slug', 'description', $mockAlbumCategory->getId(), 'thumb', false);

        $_GET['category'] = $mockAlbumCategory->getName();
        $albumCatergoryRepo = new \Lib\Repository\AlbumCategory();
        $albumCatergoryDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $albumCatergoryDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\AlbumCategory::TABLENAME))->will($this->returnValue(\Lib\Repository\AlbumCategory::TABLENAME));
        $albumCatergoryDatabase->method('fetchOne')
            ->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\AlbumCategory::TABLENAME . '` WHERE `name` = ?'), $this->equalTo([$mockAlbumCategory->getName()]), $this->equalTo('s'))
            ->will($this->returnValue(null));
        $albumCatergoryRepo->setDatabase($albumCatergoryDatabase);

        $controller = new Albums();
        $controller->setAlbumCategoryRepository($albumCatergoryRepo);
        $controller->getArray();
    }
}
