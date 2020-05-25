<?php

namespace Tests\Browser;

use App\Models\Status;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCanCommentStatusTest extends DuskTestCase
{
    use DatabaseMigrations;
    /** @test */
    public function authenticated_users_can_comment_status()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($status, $user){
            $comment = 'Mi primer comentario';
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->type('comment', $comment)
                ->press('@comment-btn')
                ->waitForText($comment)
                ->assertSee($comment)
            ;
        });
    }
}
