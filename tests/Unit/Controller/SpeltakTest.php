<?php

namespace Unit\Controller;

/**
 * Class SpeltakTest
 */
class SpeltakTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testGetArray()
    {
        $speltakName = 'Test Speltak';
        $description = 'SPELTAK DESCRIPTION';
        $controller = new \Controller\Speltak();
        $mockSpeltak = new \Lib\Data\Speltak(0, $speltakName, '', $description);

        $speltakRepo = new \Lib\Repository\Speltak();
        $database = $this->createMock(\Lib\Core\Database::CLASS);
        $database->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Speltak::TABLENAME))->will($this->returnValue(\Lib\Repository\Speltak::TABLENAME));

        $database->method('fetchOne')->with($this->equalTo('SELECT * FROM `group` WHERE name = ?'), $this->equalTo([$speltakName]), $this->equalTo('s'))->will($this->returnValue([
            'id' => 0,
            'name' => $speltakName,
            'picture' => '',
            'description' => $description,
        ]));

        $speltakRepo->setDatabase($database);
        $controller->setSpeltakRepository($speltakRepo);

        $_GET['name'] = $speltakName;
        $result = $controller->getArray();
        $this->assertEquals($result, [
            'speltak' => $mockSpeltak
        ]);
    }

    /**
     * @expectedException \Lib\Exception\PageNotFound
     */
    public function testGetArrayPageNotFound()
    {
        $speltakName = 'Test Speltak';
        $description = 'SPELTAK DESCRIPTION';
        $controller = new \Controller\Speltak();
        $mockSpeltak = new \Lib\Data\Speltak(0, $speltakName, '', $description);

        $speltakRepo = new \Lib\Repository\Speltak();
        $database = $this->createMock(\Lib\Core\Database::CLASS);
        $database->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Speltak::TABLENAME))->will($this->returnValue(\Lib\Repository\Speltak::TABLENAME));

        $database->method('fetchOne')->with($this->equalTo('SELECT * FROM `group` WHERE name = ?'), $this->equalTo([$speltakName]), $this->equalTo('s'))->will($this->returnValue(null));

        $speltakRepo->setDatabase($database);
        $controller->setSpeltakRepository($speltakRepo);

        $_GET['name'] = $speltakName;
        $result = $controller->getArray();
    }
}
