<?php

namespace Tests\Feature\Menu;

use App\User;
use App\MenuItem;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class UpdateTest extends TestCase
{
    /**
     * @group menus
     * @return void
     */
    public function testUpdateMenuItemTest()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $data = [
            'name' => 'Test',
            'price' => '15',
            'description' => 'ss',
            'dishTypeId' => 1,
            'menuNumber' => 5,
            'addition' => ''
        ];

        $response = $this->put('/api/menu/' . 1, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('menu_items', ['id' => 1, 'addition' => null]);
        $this->assertDatabaseHas('dishes', ['id' => 1, 'price' => $data['price'], 'name' => $data['name']]);
    }

    /**
     * @group menus
     * @return void
     */
    public function testUpdateMenuItemsWithValidationErrorsTest()
    {
        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $data = [
            'name' => 'Test',
            'price' => '15.6978sssss',
            'description' => '',
            'dishTypeId' => 1,
            'menuNumber' => 5,
            'addition' => 'SDSDDS'
        ];

        $response = $this->put('/api/menu/1', $data);

        $response->assertStatus(302);
    }
}
