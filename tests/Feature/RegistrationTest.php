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
        $userData = $this->userValidData();

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

    /** @test */

    function the_name_is_required()
    {
        $this->post(
            route('register'),
                $this->userValidData(['name' => null])
        )->assertSessionHasErrors('name');
    }

    /** @test */

    function the_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => 1234])
        )->assertSessionHasErrors('name');
    }

    /** @test */

    function the_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => str_random(61)])
        )->assertSessionHasErrors('name');
    }

    /** @test */

    function the_first_name_is_required()
    {
        $this->post(
            route('register'),
                $this->userValidData(['first_name' => null])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */

    function the_first_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => 1234])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */

    function the_first_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => str_random(61)])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */

    function the_last_name_is_required()
    {
        $this->post(
            route('register'),
                $this->userValidData(['first_name' => null])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */

    function the_last_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => 1234])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */

    function the_last_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => str_random(61)])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */

    function the_email_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email' => null])
        )->assertSessionHasErrors('email');
    }

    /** @test */

    function the_email_must_be_a_valid_email_address()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email' => 'invalid@email'])
        )->assertSessionHasErrors('email');
    }

    /** @test */

    function the_email_must_be_unique()
    {
        factory(User::class)->create(['email' => 'test@test.es']);
        $this->post(
            route('register'),
            $this->userValidData(['email' => 'test@test.es'])
        )->assertSessionHasErrors('email');
    }

    /** @test */

    function the_password_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => null])
        )->assertSessionHasErrors('password');
    }

    /** @test */

    function the_password_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => 1234])
        )->assertSessionHasErrors('password');
    }

    /** @test */

    function the_password_must_be_at_least_6_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => 'asdfg'])
        )->assertSessionHasErrors('password');
    }

    /** @test */

    function the_password_must_be_confirmed()
    {
        $this->post(
            route('register'),
            $this->userValidData([
                'password' => 'secret',
                'password_confirmation' => null
            ])
        )->assertSessionHasErrors('password');
    }

    /**
     * @param array $overrides
     * @return array
     */
    protected function userValidData($overrides = []): array
    {
        return array_merge([
            'name' => 'JonathanGarcia',
            'first_name' => 'Jonathan',
            'last_name' => 'Garcia',
            'email' => 'test@test.es',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ], $overrides);
    }
}
