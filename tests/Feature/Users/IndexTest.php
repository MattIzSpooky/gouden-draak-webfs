<?php

namespace Tests\Feature\Users;

use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use UserRoleSeeder;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group users
     * @return void
     */
    public function testUserIndexPage()
    {
        $this->seed(UserRoleSeeder::class);
        factory(User::class, 5)->create(['user_role_id' => UserRole::WAITRESS]);
        $user = factory(User::class)->create(['user_role_id' => UserRole::ADMIN]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $response = $this->get('/api/users');

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [[
                'name',
                'badge',
                'role' => [
                    'id',
                    'name',
                    'dutch_name'
                ]
            ]]
        ]);
    }
}
