<?php

namespace Tests\Unit\Models;

use App\Models\Friendship;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FriendshipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function a_friendship_request_belongs_to_a_sender()
    {
        $sender = factory(User::class)->create();

        $friendship = factory(Friendship::class)->create(['sender_id' => $sender->id]);

        $this->assertInstanceOf(User::class, $friendship->sender);
    }

    /** @test */

    function a_friendship_request_belongs_to_a_recipient()
    {
        $recipient = factory(User::class)->create();

        $friendship = factory(Friendship::class)->create(['recipient_id' => $recipient->id]);

        $this->assertInstanceOf(User::class, $friendship->recipient);
    }
}
