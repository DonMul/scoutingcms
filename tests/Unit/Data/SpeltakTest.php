<?php

namespace Unit\Data;

/**
 * Class SpeltakTest
 */
class SpeltakTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testCreateSpeltak()
    {
        $id = rand(0, 1000);
        $name = 'Test Speltak Name';
        $picture = 'testImage.jpg';
        $description = 'Test Description';

        $speltak = new \Lib\Data\Speltak($id, $name, $picture, $description);

        $this->assertEquals($speltak->getId(), $id);
        $this->assertEquals($speltak->getName(), $name);
        $this->assertEquals($speltak->getPicture(), $picture);
        $this->assertEquals($speltak->getDescription(), $description);
    }
}
