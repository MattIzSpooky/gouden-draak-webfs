<?php

namespace Tests\Feature\Users;

use App\User;
use App\UserRole;
use Tests\TestCase;
use UserRoleSeeder;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group users
     * @return void
     */
    public function testUserShowPage()
    {
        $this->seed(UserRoleSeeder::class);
        $waitress = factory(User::class)->create(['user_role_id' => UserRole::WAITRESS]);
        $user = factory(User::class)->create(['user_role_id' => UserRole::ADMIN]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $response = $this->get('/api/users/' . $waitress->id);

        $response->assertOk();

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
    }
}
