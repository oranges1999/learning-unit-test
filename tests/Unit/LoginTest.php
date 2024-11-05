<?php

namespace Tests\Unit;

use App\Http\Requests\Auth\LoginRequest;
use PHPUnit\Framework\TestCase;
use App\Service\TestMethodService;
use ArgumentCountError;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mockery\MockInterface;

class LoginTest extends TestCase
{
    protected $method, $request;

    protected $user = [
        'email' => 'test@test.com',
        'password' => '123',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->method = new TestMethodService;
        $this->request = LoginRequest::create('/login', 'POST', $this->user);
    }

    public function test_login_success(): void
    { 
        // Arrange result of Auth::attempt = true
        Auth::shouldReceive('attempt')
            ->once()
            ->with($this->user)
            ->andReturnTrue();

        // Act
        $result = $this->method->login($this->request);

        // Assert
        $this->assertTrue($result);
    }

    public function test_login_fail(): void
    {
        // Arrange result of Auth::attempt = false
        Auth::shouldReceive('attempt')
            ->once()
            ->with($this->user)
            ->andReturnFalse();

        // Act
        $result = $this->method->login($this->request);

        // Assert
        $this->assertFalse($result);
    }

    protected function tearDown(): void
    {
        $this->method = null;
        $this->request = null;
        parent::tearDown();
    }
}
