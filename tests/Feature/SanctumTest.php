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
            ['*']
        );

        $response = $this->get('/api/user');
        dd($response);
        $response->assertOk();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoginWithCredentialsTest()
    {
        $user =  factory(User::class)->create();

        $response = $this->post('api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->dump();
    }
}
