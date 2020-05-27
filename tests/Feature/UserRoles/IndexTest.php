<?php

namespace Tests\Feature\UserRoles;

use App\User;
use App\UserRole;
use Tests\TestCase;
use UserRoleSeeder;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    /**
     * @group roles
     * @return void
     */
    public function testOverview()
    {
        $this->artisan('migrate:fresh');
        $this->seed(UserRoleSeeder::class);
        $user = factory(User::class)->create(['user_role_id' => UserRole::ADMIN]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $response = $this->get('/api/users/roles');

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [[
                'id',
                'name',
                'dutch_name'
            ]]
        ]);
    }
}
