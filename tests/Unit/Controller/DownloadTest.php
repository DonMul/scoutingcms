<?php

namespace Unit\Controller;

use Controller\Download;

/**
 * Class DownloadTest
 * @package Unit\Controller
 */
class DownloadTest extends \PHPUnit\Framework\TestCase
{
    public function testGetArray()
    {
        $mockDownload = new \Lib\Data\Download(6, 'name', \Lib\Data\Download::TYPE_REPORT, 'filename');
        $_GET['type'] = $mockDownload->getType();
        $controller = new Download();
        $downloadRepo = new \Lib\Repository\Download();
        $downloadDatabase = $this->createMock(\Lib\Core\Database::CLASS);
        $downloadDatabase->method('getFullTableName')->with($this->equalTo(\Lib\Repository\Download::TABLENAME))->will($this->returnValue(\Lib\Repository\Download::TABLENAME));
        $downloadDatabase->method('fetchAll')->with($this->equalTo('SELECT * FROM `' . \Lib\Repository\Download::TABLENAME . '` WHERE type = ? ORDER BY id DESC'), $this->equalTo([$mockDownload->getType()]), $this->equalTo('s'))->will($this->returnValue([
            [
                'id' => $mockDownload->getId(),
                'name' => $mockDownload->getName(),
                'type' => $mockDownload->getType(),
                'filename' => $mockDownload->getFilename(),
            ]
        ]));
        $downloadRepo->setDatabase($downloadDatabase);
        $controller->setDownloadRepository($downloadRepo);

        $this->assertEquals($controller->getArray(), ['downloads' => [$mockDownload]]);
    }
}
