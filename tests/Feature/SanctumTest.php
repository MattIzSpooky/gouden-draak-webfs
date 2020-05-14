<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SanctumTest extends TestCase
{

    /**
     * A basic test example.
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
     * A basic test example.
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
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserEndpoint()
    {
        $user = factory(User::class)->create();

        $r = $this->post('api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $r->assertOk();

        $token = $r->baseResponse->content();

        $response2 = $this->get('api/user', [
            'Authentication' => 'Bearer ' . $token
        ]);

        $response2->dump();
    }
}
