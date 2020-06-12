<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanGetNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function users_guest_cannot_access_notifications()
    {
        $this->getJson(route('notifications.index'))->assertStatus(401);
    }

    /** @test */

    function authenticated_users_can_get_their_notifications()
    {
        $user = factory(User::class)->create();

        $notification = factory(DatabaseNotification::class)->create(['notifiable_id' => $user->id]);

        $this->actingAs($user)->getJson(route('notifications.index'))
            ->assertJson([
                ['data' => [
                    'link' => $notification->data['link'],
                    'message' => $notification->data['message']
                ]],
            ]);
    }
}
