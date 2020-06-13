<?php

namespace Tests\Unit\Notifications;

use App\Models\Comment;
use App\Models\Status;
use App\Notifications\NewCommentNotification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewCommentNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function the_notification_is_stored_in_the_database()
    {
        $status = factory(Status::class)->create();

        $comment = factory(Comment::class)->create(['status_id' => $status->id]);

        $statusOwner = $status->user;

        $statusOwner->notify(new NewCommentNotification($comment));

        $this->assertCount(1, $statusOwner->notifications);

        $notificationsData = $statusOwner->notifications->first()->data;

        $this->assertEquals($comment->path(), $notificationsData['link']);

        $this->assertEquals("{$comment->user->name} comento tu publicacion.", $notificationsData['message']);
    }
}