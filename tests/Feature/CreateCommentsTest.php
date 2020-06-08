<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Status;
use App\Models\Comment;
use App\Events\CommentCreated;
use Illuminate\Support\Facades\Event;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

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
        $response = $this->actingAs($user)
            ->postJson(route('statuses.comments.store', $status), $comment);

        $response->assertJson([
            'data' => ['body' => $comment['body']]
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'status_id' => $status->id,
            'body' => $comment['body']
        ]);
    }

    /** @test */

    function an_event_is_fired_when_a_comment_is_created()
    {
        Event::fake([CommentCreated::class]);
        Broadcast::shouldReceive('socket')->andReturn('socket_id');

        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();
        $comment = ['body' => 'Mi primer comentario'];

        $this->actingAs($user)
            ->postJson(route('statuses.comments.store', $status), $comment);


        Event::assertDispatched(CommentCreated::class, function ($CommentCreatedEvent) {
            $this->assertInstanceOf(ShouldBroadcast::class, $CommentCreatedEvent);
            $this->assertInstanceOf(CommentResource::class, $CommentCreatedEvent->comment);
            $this->assertInstanceOf(Comment::class, $CommentCreatedEvent->comment->resource);
            $this->assertInstanceOf(Comment::class, $CommentCreatedEvent->comment->resource);
            $this->assertEquals(Comment::first()->id, $CommentCreatedEvent->comment->id);
            $this->assertEquals(
                'socket_id',
                $CommentCreatedEvent->socket,
                'The event' . get_class($CommentCreatedEvent) . ' must call the method "dontBroadcastToCurrentUser" in the constructor.');
            return true;
        });
    }

    /** @test */
    function a_comment_requires_a_body()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.comments.store', $status),['body' => '']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }
}
