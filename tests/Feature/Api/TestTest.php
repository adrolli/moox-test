<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Test;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestTest extends TestCase
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
    public function it_gets_tests_list(): void
    {
        $tests = Test::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.tests.index'));

        $response->assertOk()->assertSee($tests[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_test(): void
    {
        $data = Test::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.tests.store'), $data);

        $this->assertDatabaseHas('tests', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_test(): void
    {
        $test = Test::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
            'data' => [],
            'nullable_longtext' => $this->faker->text(),
        ];

        $response = $this->putJson(route('api.tests.update', $test), $data);

        $data['id'] = $test->id;

        $this->assertDatabaseHas('tests', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_test(): void
    {
        $test = Test::factory()->create();

        $response = $this->deleteJson(route('api.tests.destroy', $test));

        $this->assertModelMissing($test);

        $response->assertNoContent();
    }
}
