<?php

namespace Tests\Feature\Menu;

use App\User;
use App\UserRole;
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
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $data = [
            'name' => 'Test',
            'price' => 15.69,
            'description' => 'Helloo',
            'dishTypeId' => 1,
            'menuNumber' => 150,
            'addition' => 'X'
        ];

        $response = $this->post('/api/menu', $data);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'menuNumber',
                'addition',
                'dish' => [
                    'id',
                    'name',
                    'price',
                    'description',
                    'dishType' => [
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
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $data = [
            'name' => 'Test',
            'price' => '15.6978',
            'description' => '',
            'dishTypeId' => 1,
            'menuNumber' => 5,
            'addition' => ''
        ];

        $response = $this->post('/api/menu', $data);

        $response->assertStatus(302);
    }

    /**
     * @group menusStore
     * @return void
     */
    public function testStoreMenuItemsWithNullableFieldsTest()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $data = [
            'name' => 'Test',
            'price' => '15.65',
            'description' => 'dddddd',
            'dishTypeId' => 1,
            'menuNumber' => 5,
            'addition' => null
        ];

        $response = $this->post('/api/menu', $data);
        $response->assertStatus(201);
    }

    /**
     * @group menus
     * @return void
     */
    public function testStoreMenuItemTestWithUniqueValues()
    {
        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $data = [
            'name' => 'Test',
            'price' => 15.69,
            'description' => 'Helloo',
            'dishTypeId' => 1,
            'menuNumber' => 150,
            'addition' => 'X'
        ];

        $response = $this->post('/api/menu', $data);

        $secondData = [
            'name' => 'Test',
            'price' => 15.69,
            'description' => 'Helloo',
            'dishTypeId' => 1,
            'menuNumber' => 150,
            'addition' => 'X'
        ];

        $secondResponse = $this->post('/api/menu', $secondData);

        $secondResponse->assertStatus(302);
    }
}
