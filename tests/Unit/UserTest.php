<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Service\User;

class UserTest extends TestCase
{
    protected $userData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userData  = ['email'=>'huy@test.com'];
    }
    
    public function test_get_user()
    {
        $userData = $this->userData;
        $user = new User($userData);
        $this->assertSame($userData, $user->getUser());
    }

    public function test_set_password_return_true()
    {
        $userData = $this->userData;
        $user = new User($userData);
        $result = $user->setPassword('123456');
        $this->assertTrue($result);
    }

    public function test_set_password_return_false()
    {
        $userData = $this->userData;
        $user = new User($userData);
        $result = $user->setPassword('123');
        $this->assertFalse($result);
    }

    public function test_password_exist()
    {
        $userData = $this->userData;
        $user = new User($userData);
        $user->setPassword('123456');
        $this->assertTrue(array_key_exists('password', $user->getUser()));
    }

    public function test_password_is_the_same()
    {
        $userData = $this->userData;
        $user = new User($userData);
        $user->setPassword('123456');
        $data= $user->getUser();
        $expect = md5('123456');
        $this->assertSame($expect,$data['password']);
    }

    protected function tearDown(): void
    {
        $this->userData = null;
        parent::tearDown();
    }
}
