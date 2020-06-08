<?php

namespace Tests\Feature\Menu;

use App\MenuItem;
use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class DeleteTest extends TestCase
{
    /**
     * @group menu
     * @return void
     */
    public function testDeleteMenuItemTest()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $response = $this->delete('/api/menu/1');

        $response->assertStatus(200);

        $this->assertSoftDeleted('menu_items', ['id' =>  1]);

        $this->assertSoftDeleted('dishes', ['id' =>  1]);
    }
}
