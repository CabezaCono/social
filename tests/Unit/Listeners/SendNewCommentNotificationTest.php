<?php

namespace Tests\Unit\Listeners;

use Notification;
use Tests\TestCase;
use App\Models\Status;
use App\Models\Comment;
use App\Events\CommentCreated;
use App\Notifications\NewCommentNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendNewCommentNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function a_notification_is_sent_when_a_user_receives_a_new_comment()
    {
        Notification::fake();

        $status = factory(Status::class)->create();
        $comment = factory(Comment::class)->create(['status_id' => $status->id]);

        CommentCreated::dispatch($comment);

        Notification::assertSentTo(
            $status->user,
            NewCommentNotification::class,
            function ($notification, $channel) use ($comment) {
                $this->assertContains('database', $channel);
                $this->assertTrue($notification->comment->is($comment));
                return true;
            }
        );
    }
}
