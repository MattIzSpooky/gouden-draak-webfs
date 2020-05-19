<?php

namespace Tests\Feature\Menu;

use App\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
{
    /**
     * @group menus
     * @return void
     */
    public function testStoreMenuItemTest()
    {
        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $data = [
            'name' => 'Test',
            'price' => '15.69',
            'description' => 'Helloo',
            'dish_type_id' => 1,
            'menu_number' => 150,
            'addition' => 'X'
        ];

        $response = $this->post('/api/menu', $data);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => [

                'id',
                'menu_number',
                'addition',
                'dish' => [
                    'id',
                    'name',
                    'price',
                    'descriptions',
                    'dish_type' => [
                        'id',
                        'type'
                    ]
                ]
            ]
        ]);
    }

    /**
     * @group menus
     * @return void
     */
    public function testStoreMenuItemsWithValidationErrorsTest()
    {
        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $data = [
            'name' => 'Test',
            'price' => '15.6978',
            'description' => '',
            'dish_type_id' => 1,
            'menu_number' => 5,
            'addition' => ''
        ];

        $response = $this->post('/api/menu', $data);

        $response->assertStatus(302);
    }
}
