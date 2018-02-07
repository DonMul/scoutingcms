<?php

namespace Unit\Controller;

use Controller\Album;
use Lib\Data\AlbumCategory;
use Lib\Data\Picture;

/**
 * Class Albumsest
 * @package Unit\Controller
 */
class AlbumTest extends \PHPUnit\Framework\TestCase
{
    public function testGetArrayHappyFlow()
    {
        $mockAlbumCategory = new AlbumCategory(2, 'name');
        $mockAlbum = new \Lib\Data\Album(3, 'name', 'slug', 'description', $mockAlbumCategory->getId(), 'thumb', false);
        $mockPicture = new Picture(4, $mockAlbum->getId(), 'location', 'title');

        $_GET['album'] = $mockAlbum->getSlug();
        $_GET['category'] = $mockAlbumCategory->getName();
        $albumCatergoryRepo = new \Lib\Repository\AlbumCategory();
        $albumCatergoryDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $albumCatergoryDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\AlbumCategory::TABLENAME))->will($this->returnValue(\Lib\Repository\AlbumCategory::TABLENAME));
        $albumCatergoryDatabase->method('fetchOne')
            ->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\AlbumCategory::TABLENAME . '` WHERE `name` = ?'), $this->equalTo([$mockAlbumCategory->getName()]), $this->equalTo('s'))
            ->will($this->returnValue([
                'id' => $mockAlbumCategory->getId(),
                'name' => $mockAlbumCategory->getName(),
            ]));
        $albumCatergoryRepo->setDatabase($albumCatergoryDatabase);

        $albumRepo = new \Lib\Repository\Album();
        $albumDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $albumDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Album::TABLENAME))->will($this->returnValue(\Lib\Repository\Album::TABLENAME));
        $albumDatabase->method('fetchOne')
            ->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Album::TABLENAME . '` WHERE category = ? AND slug = ?'), $this->equalTo([$mockAlbumCategory->getId(), $mockAlbum->getSlug()]), $this->equalTo('ss'))
            ->will($this->returnValue([
                'id' => $mockAlbum->getId(),
                'name' => $mockAlbum->getName(),
                'slug' => $mockAlbum->getSlug(),
                'description' => $mockAlbum->getDescription(),
                'category' => $mockAlbum->getCategory(),
                'thumbnail' => $mockAlbum->getThumbnail(),
                'private' => intval($mockAlbum->isPrivate())
            ]));
        $albumRepo->setDatabase($albumDatabase);

        $pictureRepo = new \Lib\Repository\Picture();
        $pictureDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $pictureDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Picture::TABLENAME))->will($this->returnValue(\Lib\Repository\Picture::TABLENAME));
        $pictureDatabase->method('fetchAll')
            ->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Picture::TABLENAME . '` WHERE albumId = ?'), $this->equalTo([$mockAlbum->getId()]), $this->equalTo('i'))
            ->will($this->returnValue([[
                'id' => $mockPicture->getId(),
                'albumId' => $mockPicture->getAlbumId(),
                'location' => $mockPicture->getLocation(),
                'title' => $mockPicture->getTitle(),
            ]]));
        $pictureRepo->setDatabase($pictureDatabase);

        $controller = new Album();
        $controller->setAlbumCategoryRepository($albumCatergoryRepo);
        $controller->setAlbumRepository($albumRepo);
        $controller->setPictureRepository($pictureRepo);
        $result = $controller->getArray();

        $this->assertEquals($result, [
            'pictures' => [$mockPicture],
            'album' => $mockAlbum,
            'albumHash' => md5($mockAlbum->getId()),
            'category' => $mockAlbumCategory
        ]);
    }

    /**
     * @expectedException \Lib\Exception\PageNotFound
     */
    public function testGetArrayAlbumNotFound()
    {
        $mockAlbumCategory = new AlbumCategory(2, 'name');
        $mockAlbum = new \Lib\Data\Album(3, 'name', 'slug', 'description', $mockAlbumCategory->getId(), 'thumb', false);
        $mockPicture = new Picture(4, $mockAlbum->getId(), 'location', 'title');

        $_GET['album'] = $mockAlbum->getSlug();
        $_GET['category'] = $mockAlbumCategory->getName();
        $albumCatergoryRepo = new \Lib\Repository\AlbumCategory();
        $albumCatergoryDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $albumCatergoryDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\AlbumCategory::TABLENAME))->will($this->returnValue(\Lib\Repository\AlbumCategory::TABLENAME));
        $albumCatergoryDatabase->method('fetchOne')
            ->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\AlbumCategory::TABLENAME . '` WHERE `name` = ?'), $this->equalTo([$mockAlbumCategory->getName()]), $this->equalTo('s'))
            ->will($this->returnValue([
                'id' => $mockAlbumCategory->getId(),
                'name' => $mockAlbumCategory->getName(),
            ]));
        $albumCatergoryRepo->setDatabase($albumCatergoryDatabase);

        $albumRepo = new \Lib\Repository\Album();
        $albumDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $albumDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Album::TABLENAME))->will($this->returnValue(\Lib\Repository\Album::TABLENAME));
        $albumDatabase->method('fetchOne')
            ->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Album::TABLENAME . '` WHERE category = ? AND slug = ?'), $this->equalTo([$mockAlbumCategory->getId(), $mockAlbum->getSlug()]), $this->equalTo('ss'))
            ->will($this->returnValue(null));
        $albumRepo->setDatabase($albumDatabase);

        $controller = new Album();
        $controller->setAlbumCategoryRepository($albumCatergoryRepo);
        $controller->setAlbumRepository($albumRepo);
        $controller->getArray();
    }

    /**
     * @expectedException \Lib\Exception\PageNotFound
     */
    public function testGetArrayCategoryNotFound()
    {
        $mockAlbumCategory = new AlbumCategory(2, 'name');
        $mockAlbum = new \Lib\Data\Album(3, 'name', 'slug', 'description', $mockAlbumCategory->getId(), 'thumb', false);
        $mockPicture = new Picture(4, $mockAlbum->getId(), 'location', 'title');

        $_GET['album'] = $mockAlbum->getSlug();
        $_GET['category'] = $mockAlbumCategory->getName();
        $albumCatergoryRepo = new \Lib\Repository\AlbumCategory();
        $albumCatergoryDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $albumCatergoryDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\AlbumCategory::TABLENAME))->will($this->returnValue(\Lib\Repository\AlbumCategory::TABLENAME));
        $albumCatergoryDatabase->method('fetchOne')
            ->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\AlbumCategory::TABLENAME . '` WHERE `name` = ?'), $this->equalTo([$mockAlbumCategory->getName()]), $this->equalTo('s'))
            ->will($this->returnValue(null));
        $albumCatergoryRepo->setDatabase($albumCatergoryDatabase);


        $controller = new Album();
        $controller->setAlbumCategoryRepository($albumCatergoryRepo);
        $controller->getArray();
    }
}
