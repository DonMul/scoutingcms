<?php

namespace Unit\Controller;

use Controller\Sitemap;
use Lib\Data\Agenda;
use Lib\Data\Album;
use Lib\Data\AlbumCategory;
use Lib\Data\Download;
use Lib\Data\News;
use Lib\Data\Page;
use Lib\Data\Picture;
use Lib\Data\Speltak;

/**
 * Class SitemapTest
 * @package Unit\Controller
 */
class SitemapTest extends \PHPUnit\Framework\TestCase
{
    public function testSitemapGathering()
    {
        $controller = new Sitemap();

        $mockPage = new Page(0, 'Page', 'slug', 'content', 'header', false);
        $mockSpeltak = new Speltak(1, 'Name', 'picture', 'description');
        $mockAlbumCategory = new AlbumCategory(2, 'name');
        $mockAlbum = new Album(3, 'name', 'slug', 'description', $mockAlbumCategory->getId(), 'thumb', false);
        $mockPicture = new Picture(4, $mockAlbum->getId(), 'location', 'title');
        $mockAgenda = new Agenda(5, 'name', '2017-01-01', '2018-01-01', 'description', 'slug', 0);
        $mockDownload = new Download(6, 'name', Download::TYPE_REPORT, 'filename');
        $mockNewsItem = new News(7, 'title', 'content', '2018-01-01', News::STATUS_PUBLISHED);


        $pageRepo = new \Lib\Repository\Page();
        $pageDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $pageDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Page::TABLENAME))->will($this->returnValue(\Lib\Repository\Page::TABLENAME));
        $pageDatabase->method('fetchAll')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Page::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue([
            [
                'id' => $mockPage->getId(),
                'title' => $mockPage->getTitle(),
                'slug' => $mockPage->getSlug(),
                'content' => $mockPage->getContent(),
                'header' => $mockPage->getHeader(),
                'isHomepage' => intval($mockPage->isHomepage())
            ]
        ]));
        $pageRepo->setDatabase($pageDatabase);

        $speltakRepo = new \Lib\Repository\Speltak();
        $speltakDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $speltakDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Speltak::TABLENAME))->will($this->returnValue(\Lib\Repository\Speltak::TABLENAME));
        $speltakDatabase->method('fetchAll')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Speltak::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue([
            [
                'id' => $mockSpeltak->getId(),
                'name' => $mockSpeltak->getName(),
                'picture' => $mockSpeltak->getPicture(),
                'description' => $mockSpeltak->getDescription()
            ]
        ]));
        $speltakRepo->setDatabase($speltakDatabase);

        $albumCatergoryRepo = new \Lib\Repository\AlbumCategory();
        $albumCatergoryDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $albumCatergoryDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\AlbumCategory::TABLENAME))->will($this->returnValue(\Lib\Repository\AlbumCategory::TABLENAME));
        $albumCatergoryDatabase->method('fetchAll')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\AlbumCategory::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue([
            [
                'id' => $mockAlbumCategory->getId(),
                'name' => $mockAlbumCategory->getName(),
            ]
        ]));
        $albumCatergoryRepo->setDatabase($albumCatergoryDatabase);

        $albumRepo = new \Lib\Repository\Album();
        $albumDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $albumDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Album::TABLENAME))->will($this->returnValue(\Lib\Repository\Album::TABLENAME));
        $albumDatabase->method('fetchAll')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Album::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue([
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

        $pictureRepo = new \Lib\Repository\Picture();
        $pictureDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $pictureDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Picture::TABLENAME))->will($this->returnValue(\Lib\Repository\Picture::TABLENAME));
        $pictureDatabase->method('fetchAll')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Picture::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue([
            [
                'id' => $mockPicture->getId(),
                'albumId' => $mockPicture->getAlbumId(),
                'location' => $mockPicture->getLocation(),
                'title' => $mockPicture->getTitle(),
            ]
        ]));
        $pictureRepo->setDatabase($pictureDatabase);

        $agendaRepo = new \Lib\Repository\Agenda();
        $agendaDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $agendaDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Agenda::TABLENAME))->will($this->returnValue(\Lib\Repository\Agenda::TABLENAME));
        $agendaDatabase->method('fetchAll')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Agenda::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue([
            [
                'id' => $mockAgenda->getId(),
                'name' => $mockAgenda->getName(),
                'startDate' => $mockAgenda->getStartDate(),
                'endDate' => $mockAgenda->getEndDate(),
                'description' => $mockAgenda->getDescription(),
                'slug' => $mockAgenda->getSlug(),
                'category' => $mockAgenda->getCategory()
            ]
        ]));
        $agendaRepo->setDatabase($agendaDatabase);

        $downloadRepo = new \Lib\Repository\Download();
        $downloadDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $downloadDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Download::TABLENAME))->will($this->returnValue(\Lib\Repository\Download::TABLENAME));
        $downloadDatabase->method('fetchAll')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Download::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue([
            [
                'id' => $mockDownload->getId(),
                'name' => $mockDownload->getName(),
                'type' => $mockDownload->getType(),
                'filename' => $mockDownload->getFilename(),
            ]
        ]));
        $downloadRepo->setDatabase($downloadDatabase);

        $newsRepo = new \Lib\Repository\News();
        $newsDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $newsDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\News::TABLENAME))->will($this->returnValue(\Lib\Repository\News::TABLENAME));
        $newsDatabase->method('fetchAll')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\News::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue([
            [
                'id' => $mockNewsItem->getId(),
                'title' => $mockNewsItem->getTitle(),
                'content' => $mockNewsItem->getContent(),
                'published' => $mockNewsItem->getPublished(),
                'status' => $mockNewsItem->getStatus(),
            ]
        ]));
        $newsRepo->setDatabase($newsDatabase);

        $controller->setPageRepository($pageRepo);
        $controller->setSpeltakRepository($speltakRepo);
        $controller->setAlbumCategoryRepository($albumCatergoryRepo);
        $controller->setAlbumRepository($albumRepo);
        $controller->setPictureRepository($pictureRepo);
        $controller->setAgendaRepository($agendaRepo);
        $controller->setDownloadRepository($downloadRepo);
        $controller->setNewsRepository($newsRepo);

        $_SERVER['HTTP_HOST'] = 'example.com';
        $this->assertEquals($controller->getArray(), [
            'pages' => [$mockPage],
            'groups' => [$mockSpeltak],
            'albumCategories' => [$mockAlbumCategory],
            'albums' => [$mockAlbum],
            'pictures' => [$mockPicture],
            'agendaItems' => [$mockAgenda],
            'downloads' => [$mockDownload],
            'newsItems' => [$mockNewsItem],
            'host' => (\Lib\Core\Settings::getInstance()->get('ssl') == true ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']
        ]);
    }
}
