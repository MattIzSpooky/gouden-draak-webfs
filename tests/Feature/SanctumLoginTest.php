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
     *
     * @return void
     */
    public function testLogoutTest()
    {
        $user = factory(User::class)->create();

        $loginResponse = $this->post('api/login', [
            'badge' => $user->badge,
            'password' => 'password'
        ]);

        $loginResponse->assertOk();

        $token = $loginResponse->baseResponse->content();

        $userResponse = $this->get('api/user', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $userResponse->assertOk();

        $logoutResponse = $this->post('/api/logout');

        $logoutResponse->assertOk();

        $this->assertDatabaseMissing('personal_access_tokens', ['tokenable_id' => $user->id]);
    }

    /**
     *
     * @return void
     */
    public function testLoginWithCredentialsTest()
    {
        $user = factory(User::class)->create();

        $loginResponse = $this->post('api/login', [
            'badge' => $user->badge,
            'password' => 'password'
        ]);

        $loginResponse->assertOk();

        $token = $loginResponse->baseResponse->content();

        $userResponse = $this->get('api/user', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $userResponse->assertOk();
    }

    /**
     *
     * @return void
     */
    public function testLoginWithWrongCredentialsTest()
    {
        $user = factory(User::class)->create();

        $response = $this->post('api/login', [
            'badge' => $user->badge,
            'password' => 'passwordddddddd'
        ]);

        $response->assertStatus(302);

        $token = $response->baseResponse->content();

        $userResponse = $this->get('api/user', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $userResponse->assertStatus(302);
    }
}
