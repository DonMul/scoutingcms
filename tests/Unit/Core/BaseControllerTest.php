<?php

/**
 * Class BaseControllerTest
 * @package Unit\Core
 */
class BaseControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testGetVariable()
    {
        $controller = new mockController();
        $uniqName = uniqid();
        $uniqVal = md5($uniqName);
        $otherUniqVal = md5($uniqVal);
        $_GET[$uniqName] = $uniqVal;

        $this->assertEquals($controller->testGetVariable($uniqName), $uniqVal);
        $this->assertEquals($controller->testGetVariable(md5($uniqName), $otherUniqVal), $otherUniqVal);
    }

    public function testSetRequiresLogin()
    {
        $controller = new mockController();
        $this->assertTrue($controller->testRequiresLogin(true));
        $this->assertFalse($controller->testRequiresLogin(false));
    }

    public function testAddError()
    {
        $message = "Test Message";
        $message2 = "Test Message 2";

        $controller = new mockController();
        $this->assertEquals($controller->testAddError($message, []), [$message]);
        $this->assertEquals($controller->testAddError($message2, []), [$message,$message2]);
        $this->assertEquals($controller->testAddError("", []), [$message,$message2]);
    }

    public function testExecute()
    {
        $controller = new mockController();
        $controller->execute();

        $this->assertEquals($controller->templateLocation, 'mockController.html.twig');
        $this->assertEquals($controller->context, []);
    }

    public function testServeTemplate()
    {
        $controller = new mockController();

        $mockNewsItem = new \Lib\Data\News(7, 'title', 'content', '2018-01-01', \Lib\Data\News::STATUS_PUBLISHED);
        $mockPage = new \Lib\Data\Page(0, 'Page', 'slug', 'content', 'header', false);
        $mockSpeltak = new \Lib\Data\Speltak(1, 'Name', 'picture', 'description');
        $mockMenu = new \Lib\Data\Menu(2, 0, 'name', \Lib\Data\Menu::TYPE_URL, '/', 0);

        $menuRepo = new \Lib\Repository\Menu();
        $menuDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $menuDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Menu::TABLENAME))->will($this->returnValue(\Lib\Repository\Menu::TABLENAME));
        $menuDatabase->method('fetchAll')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Menu::TABLENAME . '`'), $this->equalTo([]), $this->equalTo(''))->will($this->returnValue([
            [
                'id' => $mockMenu->getId(),
                'parentId' => $mockMenu->getParentId(),
                'name' => $mockMenu->getName(),
                'type' => $mockMenu->getType(),
                'value' => $mockMenu->getValue(),
                'position' => $mockMenu->getPosition(),
            ]
        ]));
        $menuRepo->setDatabase($menuDatabase);

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

        $controller->setMenuRepository($menuRepo);
        $controller->setNewsRepository($newsRepo);
        $controller->setPageRepository($pageRepo);
        $controller->setSpeltakRepository($speltakRepo);

        $controller->testRequiresLogin(false);
        $controller->testServeTemplate('mockController.html.twig', [
            'Test' => 'Aaa'
        ]);

        $this->assertEquals($controller->templateLocation, 'mockController.html.twig');
        $this->assertEquals($controller->context, [
            'context' => [
                'Test' => 'Aaa'
            ],
            'languages' => \Lib\Core\Translation::getInstance()->getAllLanguages(),
            'request' => [],
            'loggedIn' => false,
            'language' => 'nl',
            'menu' => [
                $mockMenu->getPosition() => [
                    'name' => $mockMenu->getName(),
                    'url' => $mockMenu->getValue(),
                    'subItems' => []
                ]
            ],
            'pages' => [$mockPage],
            'groups' => [$mockSpeltak],
            'albumCategories' => [$mockSpeltak],
            'title' => $controller->getTitle(),
            'description' => $controller->getDescription(),
        ]);
    }

    public function testExecuteNotLoggedIn()
    {
        $controller = new mockController();
        $controller->testRequiresLogin(true);
        $controller->execute();
        $this->assertEquals($controller->templateLocation, "User/Login.html.twig");
        $this->assertEquals($controller->context, []);
    }

    public function testUploadPath()
    {
        $settings =  \Lib\Core\Settings::getInstance()->getAll();
        \Lib\Core\Settings::getInstance()->overrideSettings([
            'cdn' => [
                'enabled' => false,
            ],
        ]);

        $mockDownload = new \Lib\Data\Download(1, 'Mock', \Lib\Data\Download::TYPE_REPORT, 'test.pdf');
        $mockAlbumCategory = new \Lib\Data\AlbumCategory(1, 'testCat');
        $mockAlbum = new \Lib\Data\Album(1, 'test', 'test','desctiption', $mockAlbumCategory->getId(), 'thumb.png', false);
        $mockImage = new \Lib\Data\Picture(1, $mockAlbum->getId(), 'test.png', 'Test');

        $downloadRepo = new \Lib\Repository\Download();
        $downloadDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $downloadDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Download::TABLENAME))->will($this->returnValue(\Lib\Repository\Download::TABLENAME));
        $downloadDatabase->method('fetchOne')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Download::TABLENAME . '` WHERE id = ?'), $this->equalTo([$mockDownload->getId()]), $this->equalTo('i'))->will($this->returnValue([
            'id' => $mockDownload->getId(),
            'name' => $mockDownload->getName(),
            'type' => $mockDownload->getType(),
            'filename' => $mockDownload->getFilename()
        ]));
        $downloadRepo->setDatabase($downloadDatabase);

        $albumRepo = new \Lib\Repository\Album();
        $albumDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $albumDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Album::TABLENAME))->will($this->returnValue(\Lib\Repository\Album::TABLENAME));
        $albumDatabase->method('fetchOne')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Album::TABLENAME . '` WHERE id = ?'), $this->equalTo([$mockAlbum->getId()]), $this->equalTo('i'))->will($this->returnValue([
            'id' => $mockAlbum->getId(),
            'name' => $mockAlbum->getName(),
            'slug' => $mockAlbum->getSlug(),
            'description' => $mockAlbum->getDescription(),
            'category' => $mockAlbum->getCategory(),
            'thumbnail' => $mockAlbum->getThumbnail(),
            'private' => intval($mockAlbum->isPrivate())
        ]));
        $albumRepo->setDatabase($albumDatabase);

        $albumCategoryRepo = new \Lib\Repository\AlbumCategory();
        $albumCategoryDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $albumCategoryDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\AlbumCategory::TABLENAME))->will($this->returnValue(\Lib\Repository\AlbumCategory::TABLENAME));
        $albumCategoryDatabase->method('fetchOne')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\AlbumCategory::TABLENAME . '` WHERE id = ?'), $this->equalTo([$mockAlbumCategory->getId()]), $this->equalTo('i'))->will($this->returnValue([
            'id' => $mockAlbumCategory->getId(),
            'name' => $mockAlbumCategory->getName(),
        ]));
        $albumCategoryRepo->setDatabase($albumCategoryDatabase);

        $pictureRepo = new \Lib\Repository\Picture();
        $pictureDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $pictureDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Picture::TABLENAME))->will($this->returnValue(\Lib\Repository\Picture::TABLENAME));
        $pictureDatabase->method('fetchOne')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Picture::TABLENAME . '` WHERE id = ?'), $this->equalTo([$mockImage->getId()]), $this->equalTo('i'))->will($this->returnValue([
            'id' => $mockImage->getId(),
            'albumId' => $mockImage->getAlbumId(),
            'location' => $mockImage->getLocation(),
            'title' => $mockImage->getTitle(),
        ]));
        $pictureRepo->setDatabase($pictureDatabase);

        $controller = new mockController();
        $controller->setDownloadRepository($downloadRepo);
        $controller->setAlbumRepository($albumRepo);
        $controller->setAlbumCategoryRepository($albumCategoryRepo);
        $controller->setPictureRepository($pictureRepo);

        $this->assertEquals($controller->uploadPath($mockDownload->getId(), 'download'), '/downloads/report/test.pdf');
        $this->assertEquals($controller->uploadPath($mockAlbum->getId(), 'albumThumb'), '/upload/' . $mockAlbumCategory->getName() . '/' . $mockAlbum->getThumbnail());
        $this->assertEquals($controller->uploadPath($mockImage->getId(), 'image'), '/upload/' . $mockAlbumCategory->getName() . '/' . md5($mockAlbum->getId()) . '/' . $mockImage->getLocation());

        \Lib\Core\Settings::getInstance()->overrideSettings($settings);
    }

    public function testMd5()
    {
        $controller = new mockController();
        $this->assertEquals($controller->md5('test'), md5('test'));
    }

    public function testGetTitle()
    {
        $this->assertEquals((new rawMock())->getTitle(), '');
    }

    public function testGetDescription()
    {
        $this->assertEquals((new rawMock())->getDescription(), '');
    }
}

class rawMock extends \Lib\Core\BaseController
{
    public function getTitle()
    {
        return parent::getTitle();
    }

    public function getDescription()
    {
        return parent::getDescription();
    }

    public function getArray()
    {
       return [];
    }
}

class mockController extends \Lib\Core\BaseController
{
    public $context;
    public $templateLocation;

    public function testAddError($message, $params = [])
    {
        $this->addError($message, $params);
        return $this->errors;
    }

    public function testRequiresLogin(bool $newValue)
    {
        $this->setRequiresLogin($newValue);
        return $this->getRequiresLogin();
    }

    public function testGetVariable($name, $default = null)
    {
        return $this->getVariable($name, $default);
    }

    public function getArray()
    {
        return [];
    }

    public function testServeTemplate($templateLocation, $context)
    {
        return parent::serveTemplate($templateLocation, $context);
    }

    protected function serveTemplate($templateLocation, $context)
    {
        $this->templateLocation = $templateLocation;
        $this->context = $context;
    }

    protected function render($templateLocation, $data)
    {
        $this->templateLocation = $templateLocation;
        $this->context = $data;
    }

    public function getTitle()
    {
        return 'TestTitle';
    }

    public function getDescription()
    {
        return 'TestDescription';
    }
}
