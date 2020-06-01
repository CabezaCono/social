<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function users_can_register()
    {
        $userData = [
            'name' => 'JonathanGarcia',
            'first_name' => 'Jonathan',
            'last_name' => 'Garcia',
            'email' => 'test@test.es',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $response = $this->post(route('register', $userData));

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'name' => 'JonathanGarcia',
            'first_name' => 'Jonathan',
            'last_name' => 'Garcia',
            'email' => 'test@test.es'
        ]);

        $this->assertTrue(
            Hash::check('secret', User::first()->password)
        );
    }
}
