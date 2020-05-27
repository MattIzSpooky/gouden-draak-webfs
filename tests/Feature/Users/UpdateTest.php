<?php

namespace Tests\Feature\Users;

use App\User;
use App\UserRole;
use Tests\TestCase;
use UserRoleSeeder;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UpdateTest extends TestCase
{
    /**
     * @group users
     * @return void
     */
    public function testUpdateUser()
    {
        $this->artisan('migrate:fresh');
        $this->seed(UserRoleSeeder::class);
        $password = Hash::make('Hello');
        $waitress = factory(User::class)
            ->create(['user_role_id' => UserRole::WAITRESS, 'password' => $password]);
        $user = factory(User::class)->create(['user_role_id' => UserRole::ADMIN]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $data = [
            'name' => 'Hello',
            'user_role_id' => UserRole::ADMIN,
            'password' => null,
            'badge' =>  $waitress->badge
        ];

        $response = $this->put('/api/users/' . $waitress->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $waitress->id,
            'name' => $data['name'],
            'user_role_id' => UserRole::ADMIN,
            'password' =>  $password
        ]);
    }

    /**
     * @group users
     * @return void
     */
    public function testUpdatePasswordUser()
    {
        $this->artisan('migrate:fresh');
        $this->seed(UserRoleSeeder::class);
        $waitress = factory(User::class)->create(['user_role_id' => UserRole::WAITRESS]);
        $user = factory(User::class)->create(['user_role_id' => UserRole::ADMIN]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $data = [
            'id' => $waitress->id,
            'name' => $waitress->name,
            'user_role_id' => $waitress->user_role_id,
            'badge' =>  $waitress->badge,
            'password' => 'Hello12345',
        ];

        $response = $this->put('/api/users/' . $waitress->id, $data);

        $response->assertStatus(200);

        $this->assertTrue(Hash::check($data['password'], User::find($waitress->id)->getAuthPassword()));

        $this->assertDatabaseHas('users', [
            'id' => $waitress->id,
            'badge' => $waitress->badge,
            'name' => $waitress->name,
        ]);
    }
}
