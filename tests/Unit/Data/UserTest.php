<?php

namespace Unit\Data;

/**
 * Class UserTest
 */
class UserTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testCreateUser()
    {
        $id = rand(0, 1000);
        $username = 'TestUsername';
        $password = 'T3stP@ssword';
        $nickName = 'Test Nick';
        $email = 'test@example.com';

        $user = new \Lib\Data\User($id, $username, $password, $nickName, $email);

        $this->assertEquals($user->getId(), $id);
        $this->assertEquals($user->getUsername(), $username);
        $this->assertEquals($user->getPassword(), $password);
        $this->assertEquals($user->getNickname(), $nickName);
        $this->assertEquals($user->getEmail(), $email);
    }
}
