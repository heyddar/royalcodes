<?php

namespace Tests\Unit\Http\Controllers\Api\v01\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Register
     */
    public function test_register_should_be_validated()
    {
        $response = $this->postJson(route('auth.register'));

        $response ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function test_new_user_can_register()
    {
        $response = $this->postJson(route('auth.register'),[
            'name'  => "admin",
            'email' => "admin@gmail.com",
            'password' => "password"
        ]);

        $response ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * Test Login
     */
    public function test_login_should_be_validate()
    {
        $response = $this->postJson(route('auth.login'));

        $response ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_user_can_login_with_credentials()
    {
        $user = factory(User::class)->create();
        $response = $this->postJson(route('auth.login'),[
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test Logged In User
     */
    public function test_show_user_info_if_logged_in()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get(route('auth.user'));

        $response ->assertStatus(Response::HTTP_OK);
    }
    /**
     * Test logout
     */
    public function test_logged_in_user_can_logout()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->postJson(route('auth.logout'));

        $response ->assertStatus(Response::HTTP_OK);
    }

}
