<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
    }
    /**
     * A basic unit test example.
     */
    public function test_auth_user_access_dashboard_return_200(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('dashboard'));
        $response->assertStatus(200);
    }

    public function test_not_auth_user_access_dashboard(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertStatus(302);
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown();
    }
}
