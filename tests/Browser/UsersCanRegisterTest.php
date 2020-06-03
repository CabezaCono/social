<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanRegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */

    public function user_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'JonathanGarcia')
                ->type('first_name', 'Jonathan')
                ->type('last_name', 'Garcia')
                ->type('email', 'test@test.es')
                ->type('password', 'secret')
                ->type('password_confirmation', 'secret')
                ->press('@register-btn')
                ->assertPathIs('/')
                ->assertAuthenticated()
            ;
        });
    }

    /**
     * @test
     * @throws \Throwable
     */

    public function user_cannot_register_with_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', '')
                ->press('@register-btn')
                ->assertPathIs('/register')
                ->assertPresent('@validation-errors')
            ;
        });
    }
}
