<?php

namespace Tests\Browser;

use App\Models\Status;
use App\User;
use Illuminate\Notifications\DatabaseNotification;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanGetTheirNotificationsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    public function users_can_see_their_notifications_in_the_navbar()
    {
        $user = factory(User::class)->create();

        $status = factory(Status::class)->create();

        $notification = factory(DatabaseNotification::class)->create([
            'notifiable_id' => $user->id,
            'data' => [
                'message' => 'Haz recibido un like',
                'link' => route('statuses.show', $status)
            ],
        ]);
        $this->browse(function (Browser $browser) use ($user, $status, $notification) {
            $browser->loginAs($user)
                ->visit('/')
                ->resize(1024, 768)
                ->click('@notifications')
                ->assertSee('Haz recibido un like')
                ->click("@{$notification->id}")
                ->assertUrlIs($status->path())
            ;
        });
    }
}
