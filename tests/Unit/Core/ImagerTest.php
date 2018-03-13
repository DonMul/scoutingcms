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

    public function testUploadImageWithoutCdn()
    {
        $imager = new \Lib\Core\Imager();
        $settings = \Lib\Core\Settings::getInstance()->getAll();
        \Lib\Core\Settings::getInstance()->overrideSettings(['cdn' => ['enabled' => false]]);

        $imager->uploadImage(
            DIRECTORY_SEPARATOR . 'tmp ' . DIRECTORY_SEPARATOR . 'test.png',
            sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'test.png'
        );

        \Lib\Core\Settings::getInstance()->overrideSettings($settings);
        $this->assertTrue(true);
    }

    public function testResizeImage()
    {
        $imager = new \Lib\Core\Imager();

        $this->assertTrue($imager->resizeImage(ROOT . '/../tests/img/test.png', 1920, 1080));
        $this->assertTrue($imager->resizeImage(ROOT . '/../tests/img/test.jpg', 1920, 1080));
        $this->assertTrue($imager->resizeImage(ROOT . '/../tests/img/test.jpg', 1080, 1920));
        $this->assertTrue($imager->resizeImage(ROOT . '/../tests/img/test.png', 2, 1));
        $this->assertTrue($imager->resizeImage(ROOT . '/../tests/img/test.png', 1, 2));
        $this->assertTrue($imager->resizeImage(ROOT . '/../tests/img/test.jpg', 1, 2));
        $this->assertTrue($imager->resizeImage(ROOT . '/../tests/img/test.jpg', 2, 1));

        $this->assertFalse($imager->resizeImage(ROOT . '/../tests/img/test.svg', 1920, 1080));
    }
}
