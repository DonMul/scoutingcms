<?php

namespace Unit\Data;

/**
 * Class PermissionTest
 */
class PermissionTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testCreatePermission()
    {
        $id = rand(0, 1000);
        $name = 'Test Permission Name';
        $permission = new \Lib\Data\Permission($id, $name);

        $this->assertEquals($permission->getId(), $id);
        $this->assertEquals($permission->getName(), $name);
    }
}
