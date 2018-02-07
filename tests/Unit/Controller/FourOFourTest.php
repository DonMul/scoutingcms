<?php

namespace Unit\Controller;

use Controller\FourOFour;

/**
 * Class FourOFourTest
 * @package Unit\Controller
 */
class FourOFourTest extends \PHPUnit\Framework\TestCase
{
    public function testGetArray()
    {
        $this->assertEquals((new FourOFour())->getArray(), []);
    }
}
