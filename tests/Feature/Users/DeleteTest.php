<?php

namespace Tests\Feature\Users;

use App\User;
use App\UserRole;
use Tests\TestCase;
use UserRoleSeeder;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTest extends TestCase
{
    /**
     * @group users
     * @return void
     */
    public function testDeleteUser()
    {
        $this->artisan('migrate:fresh');
        $this->seed(UserRoleSeeder::class);
        $waitress = factory(User::class)->create(['user_role_id' => UserRole::WAITRESS]);
        $user = factory(User::class)->create(['user_role_id' => UserRole::ADMIN]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $response = $this->delete('/api/users/' . $waitress->id);

        $response->assertOk();

        $this->assertDatabaseMissing('users', ['id' => $waitress->id, 'badge' => $waitress->badge]);
    }
}
