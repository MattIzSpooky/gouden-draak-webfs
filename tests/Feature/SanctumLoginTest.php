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
     * @group auth
     * @return void
     */
    public function testLoginTest()
    {
        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->get('/api/info');

        $response->assertOk();
    }

    /**
     * @group auth
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

        $userResponse = $this->get('api/info', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $userResponse->assertOk();

        $logoutResponse = $this->post('/api/logout');

        $logoutResponse->assertOk();

        $this->assertDatabaseMissing('personal_access_tokens', ['tokenable_id' => $user->id]);
    }

    /**
     * @group auth
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

        $userResponse = $this->get('api/info', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $userResponse->assertOk();
    }

    /**
     * @group auth
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

        $userResponse = $this->get('api/info', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $userResponse->assertStatus(302);
    }
}
