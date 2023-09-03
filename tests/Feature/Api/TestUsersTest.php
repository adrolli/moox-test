<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Test;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestUsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_test_users(): void
    {
        $test = Test::factory()->create();
        $user = User::factory()->create();

        $test->users()->attach($user);

        $response = $this->getJson(route('api.tests.users.index', $test));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_test(): void
    {
        $test = Test::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.tests.users.store', [$test, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $test
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_test(): void
    {
        $test = Test::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.tests.users.store', [$test, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $test
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
