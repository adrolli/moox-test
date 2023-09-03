<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Test;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTestsTest extends TestCase
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
    public function it_gets_user_tests(): void
    {
        $user = User::factory()->create();
        $test = Test::factory()->create();

        $user->tests()->attach($test);

        $response = $this->getJson(route('api.users.tests.index', $user));

        $response->assertOk()->assertSee($test->title);
    }

    /**
     * @test
     */
    public function it_can_attach_tests_to_user(): void
    {
        $user = User::factory()->create();
        $test = Test::factory()->create();

        $response = $this->postJson(
            route('api.users.tests.store', [$user, $test])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->tests()
                ->where('tests.id', $test->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_tests_from_user(): void
    {
        $user = User::factory()->create();
        $test = Test::factory()->create();

        $response = $this->deleteJson(
            route('api.users.tests.store', [$user, $test])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->tests()
                ->where('tests.id', $test->id)
                ->exists()
        );
    }
}
