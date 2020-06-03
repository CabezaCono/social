<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanLoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @test
     * @throws \Throwable
     */
    public function registered_users_can_login()
    {

        factory(User::class)->create(['email' => 'jonathan@email.com']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'jonathan@email.com')
                    ->type('password', 'secret')
                    ->press('@login-btn')
                    ->assertPathIs('/')
                    ->assertAuthenticated()
            ;
        });
    }

    /**
     * @test
     * @throws \Throwable
     */

    public function user_cannot_login_with_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', '')
                ->press('@login-btn')
                ->assertPathIs('/login')
                ->assertPresent('@validation-errors')
            ;
        });
    }
}
