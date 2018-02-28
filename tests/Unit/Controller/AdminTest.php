<?php

namespace Unit\Controller;

use Lib\Repository\Speltak;
use Lib\Repository\Agenda;
use Lib\Repository\Album;
use Lib\Repository\Download;
use Lib\Repository\News;
use Lib\Repository\Page;
use Lib\Repository\Picture;
use Lib\Repository\User;


/**
 * Class AdminTest
 * @package Unit\Controller
 */
class AdminTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testGetArray()
    {
        $controller = new \Controller\Admin;

        $agendaRepo = new Agenda();
        $agendaDatabsae = $this->createMock(\Lib\Core\Database::CLASS);
        $agendaDatabsae->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Agenda::TABLENAME))->will($this->returnValue(\Lib\Repository\Agenda::TABLENAME));
        $agendaDatabsae->method('fetchOne')->with($this->equalTo('SELECT COUNT(1) AS cnt FROM `' . \Lib\Repository\Agenda::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue(['cnt' => 1]));
        $agendaRepo->setDatabase($agendaDatabsae);
        $controller->setAgendaRepository($agendaRepo);

        $albumRepo = new Album();
        $albumDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $albumDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Album::TABLENAME))->will($this->returnValue(\Lib\Repository\Album::TABLENAME));
        $albumDatabase->method('fetchOne')->with($this->equalTo('SELECT COUNT(1) AS cnt FROM `' . \Lib\Repository\Album::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue(['cnt' => 1]));
        $albumRepo->setDatabase($albumDatabase);
        $controller->setAlbumRepository($albumRepo);

        $downloadRepo = new Download();
        $downloadDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $downloadDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Download::TABLENAME))->will($this->returnValue(\Lib\Repository\Download::TABLENAME));
        $downloadDatabase->method('fetchOne')->with($this->equalTo('SELECT COUNT(1) AS cnt FROM `' . \Lib\Repository\Download::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue(['cnt' => 1]));
        $downloadRepo->setDatabase($downloadDatabase);
        $controller->setDownloadRepository($downloadRepo);

        $newsRepo = new News();
        $newsDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $newsDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\News::TABLENAME))->will($this->returnValue(\Lib\Repository\News::TABLENAME));
        $newsDatabase->method('fetchOne')->with($this->equalTo('SELECT COUNT(1) AS cnt FROM `' . \Lib\Repository\News::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue(['cnt' => 1]));
        $newsRepo->setDatabase($newsDatabase);
        $controller->setNewsRepository($newsRepo);

        $pageRepo = new Page();
        $pageDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $pageDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Page::TABLENAME))->will($this->returnValue(\Lib\Repository\Page::TABLENAME));
        $pageDatabase->method('fetchOne')->with($this->equalTo('SELECT COUNT(1) AS cnt FROM `' . \Lib\Repository\Page::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue(['cnt' => 1]));
        $pageRepo->setDatabase($pageDatabase);
        $controller->setPageRepository($pageRepo);

        $pictureRepo = new Picture();
        $pictureDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $pictureDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Picture::TABLENAME))->will($this->returnValue(\Lib\Repository\Picture::TABLENAME));
        $pictureDatabase->method('fetchOne')->with($this->equalTo('SELECT COUNT(1) AS cnt FROM `' . \Lib\Repository\Picture::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue(['cnt' => 1]));
        $pictureRepo->setDatabase($pictureDatabase);
        $controller->setPictureRepository($pictureRepo);

        $speltakRepo = new Speltak();
        $speltakDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $speltakDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Speltak::TABLENAME))->will($this->returnValue(\Lib\Repository\Speltak::TABLENAME));
        $speltakDatabase->method('fetchOne')->with($this->equalTo('SELECT COUNT(1) AS cnt FROM `' . \Lib\Repository\Speltak::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue(['cnt' => 1]));
        $speltakRepo->setDatabase($speltakDatabase);
        $controller->setSpeltakRepository($speltakRepo);

        $userRepo = new User();
        $userDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $userDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\User::TABLENAME))->will($this->returnValue(\Lib\Repository\User::TABLENAME));
        $userDatabase->method('fetchOne')->with($this->equalTo('SELECT COUNT(1) AS cnt FROM `' . \Lib\Repository\User::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue(['cnt' => 1]));
        $userRepo->setDatabase($userDatabase);
        $controller->setUserRepository($userRepo);

        $this->assertEquals($controller->getArray(), [
            'totals' => [
                'agenda' => 1,
                'album' => 1,
                'download' => 1,
                'news' => 1,
                'page' => 1,
                'picture' => 1,
                'speltak' => 1,
                'user' => 1,
            ],
        ]);
    }
}
