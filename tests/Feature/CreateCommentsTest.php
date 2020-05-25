<?php

namespace Tests\Feature;

use App\Models\Status;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function guest_users_cannot_create_comments()
    {
        $status = factory(Status::class)->create();
        $comment = ['body' => 'Mi primer comentario'];

        $response = $this->postJson(route('statuses.comments.store', $status), $comment);

        $response->assertStatus(401);

    }

    /** @test */

    function authenticated_users_can_comment_statuses()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();
        $comment = ['body' => 'Mi primer comentario'];
        $this->actingAs($user)
            ->postJson(route('statuses.comments.store', $status), $comment);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'status_id' => $status->id,
            'body' => $comment['body']
        ]);
    }
}
