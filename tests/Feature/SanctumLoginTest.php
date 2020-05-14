<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SanctumLoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic login
     *
     * @return void
     */
    public function testLoginTest()
    {
        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->get('/api/user');

        $response->assertOk();
    }

    /**
     * A basic login with credientials
     *
     * @return void
     */
    public function testLoginWithCredentialsTest()
    {
        $user = factory(User::class)->create();

        $response = $this->post('api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertOk();

        $token = $response->baseResponse->content();

        $userResponse = $this->get('api/user', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $userResponse->assertOk();
    }

    /**
     * A basic login with credientials
     *
     * @return void
     */
    public function testLoginWithWrongCredentialsTest()
    {
        $user = factory(User::class)->create();

        $response = $this->post('api/login', [
            'email' => $user->email,
            'password' => 'passworddddddddd'
        ]);

        $response->assertStatus(302);

        $token = $response->baseResponse->content();

        $userResponse = $this->get('api/user', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $userResponse->assertStatus(302);
    }
}
