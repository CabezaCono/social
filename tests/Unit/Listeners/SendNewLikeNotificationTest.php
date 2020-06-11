<?php

namespace Tests\Unit\Listeners;

use App\User;
use Tests\TestCase;
use App\Models\Status;
use App\Events\ModelLiked;
use App\Notifications\NewLikeNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendNewLikeNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function a_notification_is_sent_when_a_user_receives_new_like()
    {
            Notification::fake();

            $statusOwner = factory(User::class)->create();

            $status = factory(Status::class)->create(['user_id' => $statusOwner->id]);

            ModelLiked::dispatch($status);

            Notification::assertSentTo($statusOwner, NewLikeNotification::class);
    }
}
