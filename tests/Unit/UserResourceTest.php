<?php

namespace Tests\Unit;

use App\Http\Resources\UserResource;
use App\Models\User;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    protected $keys = ['name', 'email'];

    /**
     * A basic unit test example.
     */
    public function test_user_resource_return_only_name_and_email(): void
    {
        $user = User::factory()->make();
        $userResource = (new UserResource($user))->toArray(request());
        $this->assertSame($this->keys,array_keys($userResource));
    }
}
