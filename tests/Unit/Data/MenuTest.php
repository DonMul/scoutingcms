<?php

namespace Unit\Data;

/**
 * Class MenuTest
 */
class MenuTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testCreateMenu()
    {
        $id = rand(0, 1000);
        $parentId = rand(0, 1000);
        $name = 'Test Album';
        $type = \Lib\Data\Menu::TYPE_GROUP;
        $value = rand(0,1000);
        $position = rand(0,1000);
        $menu = new \Lib\Data\Menu($id, $parentId, $name, $type, $value, $position);

        $this->assertEquals($menu->getId(), $id);
        $this->assertEquals($menu->getParentId(), $parentId);
        $this->assertEquals($menu->getName(), $name);
        $this->assertEquals($menu->getType(), $type);
        $this->assertEquals($menu->getValue(), $value);
        $this->assertEquals($menu->getPosition(), $position);
    }
}
