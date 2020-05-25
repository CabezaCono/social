<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_users_can_not_crate_statuses()
    {
        $response = $this->postJson(route('statuses.store'),['body' => 'Mi primer status']);
        $response->assertStatus(401);
    }

    /** @test */
    public function an_authenticate_user_can_create_statues()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'),['body' => 'Mi primer status']);
        $response->assertJson([
            'data' => ['body' => 'Mi primer status'],
        ]);

        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'Mi primer status'
        ]);
    }

    /** @test */
    function a_status_requires_a_body()
    {

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'),['body' => '']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }

    /** @test */
    function a_status_body_requires_a_minimum_length()
    {

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'),['body' => 'asdf']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }
}

