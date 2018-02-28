<?php

/**
 * Class ImagerTest
 */
class ImagerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function getMockFtpClient()
    {
        $ftpClient = $menuDatabase = $this->createMock(\Lib\Ftp\Client::CLASS);

        return $ftpClient;
    }

    /**
     *
     */
    public function testUploadImageToCdn()
    {
        $imager = new \Lib\Core\Imager();
        $this->assertInstanceOf(\Lib\Ftp\Client::class, $imager->getFtpClient());

        $client = $this->getMockFtpClient();
        $client->method('upload')->will($this->returnValue(null));

        $imager->setFtpClient($client);
        $imager->uploadImage('/tmp/test.png', '/public/upload/images/test.png');

        $this->assertTrue(true);
    }

    public function testUploadImageWithoutCdn()
    {
        $imager = new \Lib\Core\Imager();
        \Lib\Core\Settings::getInstance()->overrideSettings(['cdn' => ['enabled' => false]]);

        $imager->uploadImage(
            DIRECTORY_SEPARATOR . 'tmp ' . DIRECTORY_SEPARATOR . 'test.png',
            sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'test.png'
        );

        $this->assertTrue(true);
    }

    public function testResizeImage()
    {
        $imager = new \Lib\Core\Imager();

        $this->assertTrue($imager->resizeImage(ROOT . '/../public/img/logo.png', 1920, 1080));
        $this->assertTrue($imager->resizeImage(ROOT . '/../public/img/background.jpg', 1920, 1080));
        $this->assertTrue($imager->resizeImage(ROOT . '/../public/img/background.jpg', 1080, 1920));
        $this->assertTrue($imager->resizeImage(ROOT . '/../public/img/logo.png', 2, 1));
        $this->assertTrue($imager->resizeImage(ROOT . '/../public/img/logo.png', 1, 2));

        $this->assertFalse($imager->resizeImage(ROOT . '/../public/img/spin.svg', 1920, 1080));
    }
}
