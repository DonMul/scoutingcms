<?php

namespace Unit\Data;

/**
 * Class RoleTest
 */
class RoleTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testCreateRole()
    {
        $id = rand(0, 1000);
        $name = 'Test Role Name';
        $isAdmin = true;
        $role = new \Lib\Data\Role($id, $name, $isAdmin);

        $this->assertEquals($role->getId(), $id);
        $this->assertEquals($role->getName(), $name);
        $this->assertEquals($role->getIsAdmin(), $isAdmin);
    }
}
