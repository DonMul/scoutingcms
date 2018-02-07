<?php

namespace Unit\Data;

/**
 * Class DownloadTest
 */
class DownloadTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testCreateDownload()
    {
        $id = rand(0,1000);
        $name = 'Test Album';
        $type = \Lib\Data\Download::TYPE_REPORT;
        $fileName = 'testDownload.pdf';
        $download = new \Lib\Data\Download($id, $name, $type, $fileName);

        $this->assertEquals($download->getId(), $id);
        $this->assertEquals($download->getName(), $name);
        $this->assertEquals($download->getType(), $type);
        $this->assertEquals($download->getFilename(), $fileName);
    }
}
