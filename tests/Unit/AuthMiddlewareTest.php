<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use App\Http\Middleware\FakeAuthMiddleware;
use Illuminate\Support\Facades\Request;

class AuthMiddlewareTest extends TestCase
{
    protected $middleware, $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new FakeAuthMiddleware;
        $this->request = Request::create('/');
    }
    /**
     * A basic unit test example.
     */
    public function test_auth_user_not_redirect(): void
    {
        // Arrange
        $user = User::factory()->make();
        $this->actingAs($user);

        // Act
        $response = $this->middleware->handle($this->request, function(){});

        // Assert
        $this->assertSame($response, null);
    }

    public function test_guest_user_redirect(): void
    {
        // Act
        $response = $this->middleware->handle($this->request, function(){});

        // Assert`
        $this->assertSame($response->getStatusCode(), 302);
    }

    protected function tearDown(): void
    {
        $this->request = null;
        $this->middleware = null;
        parent::tearDown();
    }
}
