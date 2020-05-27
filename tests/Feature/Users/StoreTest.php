<?php

namespace Tests\Feature\Users;

use App\User;
use App\UserRole;
use Tests\TestCase;
use UserRoleSeeder;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
{
    /**
     * @group users
     * @return void
     */
    public function testStoreUser()
    {
        $this->artisan('migrate:fresh');
        $this->seed(UserRoleSeeder::class);

        $waitress = [
            'name' => 'Hans Muller',
            'badge' => 12345,
            'password' => 'test123',
            'user_role_id' => UserRole::WAITRESS
        ];

        $user = factory(User::class)->create(['user_role_id' => UserRole::ADMIN]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $response = $this->post('/api/users/', $waitress);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => [
                'name',
                'badge',
                'role' => [
                    'id',
                    'name',
                    'dutch_name'
                ]
            ]
        ]);

        $this->assertDatabaseHas('users', ['badge' => $waitress['badge']]);
    }
}
