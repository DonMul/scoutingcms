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
