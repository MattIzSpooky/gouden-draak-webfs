<?php

namespace Tests\Feature\Menu;

use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends TestCase
{
    /**
     * @group menu
     * @return void
     */
    public function testShowMenuItemTest()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $response = $this->get('api/menu/1');

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'id',
                'menuNumber',
                'addition',
                'dish' => [
                    'id',
                    'name',
                    'price',
                    'dishType' => [
                        'id',
                        'type'
                    ]
                ]
            ]
        ]);
    }
}
