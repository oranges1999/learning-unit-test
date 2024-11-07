<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Service\User;

class UserServiceTest extends TestCase
{
    protected $userData, $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userData  = ['email'=>'huy@test.com'];
        $this->user = new User($this->userData);
    }
    
    public function test_get_user()
    {
        $this->assertSame($this->userData, $this->user->getUser());
    }

    public function test_set_password_return_true()
    {
        $result = $this->user->setPassword('123456');
        $this->assertTrue($result);
    }

    public function test_set_password_return_false()
    {
        $result = $this->user->setPassword('123');
        $this->assertFalse($result);
    }

    public function test_password_exist()
    {
        $this->user->setPassword('123456');
        $this->assertTrue(array_key_exists('password', $this->user->getUser()));
    }

    public function test_password_is_md5_hashed()
    {
        $this->user->setPassword('123456');
        $data= $this->user->getUser();
        $expect = md5('123456');
        $this->assertSame($expect,$data['password']);
    }

    protected function tearDown(): void
    {
        $this->userData = null;
        parent::tearDown();
    }
}
