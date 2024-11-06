<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Service\User;

class UserServiceTest extends TestCase
{
    protected $userData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userData  = ['email'=>'huy@test.com'];
    }
    
    public function test_get_user()
    {
        $user = new User($this->userData);
        $this->assertSame($this->userData, $user->getUser());
    }

    public function test_set_password_return_true()
    {
        $user = new User($this->userData);
        $result = $user->setPassword('123456');
        $this->assertTrue($result);
    }

    public function test_set_password_return_false()
    {
        $user = new User($this->userData);
        $result = $user->setPassword('123');
        $this->assertFalse($result);
    }

    public function test_password_exist()
    {
        $user = new User($this->userData);
        $user->setPassword('123456');
        $this->assertTrue(array_key_exists('password', $user->getUser()));
    }

    public function test_password_is_md5_hashed()
    {
        $user = new User($this->userData);
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
