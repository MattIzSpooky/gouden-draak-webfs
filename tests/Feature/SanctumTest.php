<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SanctumTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoginTest()
    {
        Sanctum::actingAs(
            factory(User::class)->create(),
            ['view-tasks']
        );

        $response = $this->get('/api/user');

        $response->assertOk();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoginWithCredentialsTest()
    {
        $user = factory(User::class)->create();

        $cookieResponse = $this->get('/sanctum/csrf-cookie');

        dd($cookieResponse->cookie('cookies'));

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $user->password
        ], [
            'X-XSRF-TOKEN' => $cookieResponse->cookies,
        ]);

        $response->assertOk();
    }
}
