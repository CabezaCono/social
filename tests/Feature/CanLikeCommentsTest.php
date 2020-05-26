<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\User;
use Tests\TestCase;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanLikeCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_users_can_not_like_statuses()
    {
        $comment = factory(Comment::class)->create();

        $response = $this->postJson(route('comments.likes.store', $comment));

        $response->assertStatus(401);
    }

    /** @test */

    function an_authenticated_user_can_like_statuses()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $this->actingAs($user)->postJson(route('statuses.likes.store', $comment));

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'status_id' => $comment->id
        ]);
    }
}
