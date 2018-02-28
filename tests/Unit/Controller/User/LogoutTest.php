<?php

namespace Unit\Controller\User;
use Controller\User\Logout;


/**
 * Class AgendaTest
 * @package Unit\Controller
 */
class AgendaTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testGetArray()
    {
        $_SESSION[\Lib\Core\Session::SESSION_USER_KEY] = 'Test';
        $isLoggedIn = \Lib\Core\Session::getInstance()->isLoggedIn();

        $this->assertTrue($isLoggedIn);

        $controller = new Logout();
        $controller->getArray();
        $isLoggedOut = !\Lib\Core\Session::getInstance()->isLoggedIn();

        $this->assertTrue($isLoggedOut);
    }
}
