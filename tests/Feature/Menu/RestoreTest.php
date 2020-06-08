<?php

namespace Tests\Feature\Menu;

use App\Dish;
use App\User;
use App\MenuItem;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RestoreTest extends TestCase
{
    /**
     * @group menu
     * @return void
     */
    public function testRestoreMenuItemTest()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        /** @var MenuItem */
        $menu = factory(MenuItem::class)->create(['deleted_at' => now()]);
        $dish = $menu->dish()->associate(factory(Dish::class)->create(['deleted_at' => now()]))->save();

        $response = $this->post('/api/menu/restore/' . $menu->id);

        $response->assertStatus(200);

        $this->assertDatabaseHas('menu_items', ['id' =>  $menu->id, 'deleted_at' => null]);

        $this->assertDatabaseHas('dishes', ['id' =>  $menu->dish_id, 'deleted_at' => null]);
    }
}
