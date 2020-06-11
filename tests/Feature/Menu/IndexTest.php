<?php

namespace Tests\Feature\Menu;

use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    /**
     * @group menus
     * @return void
     */
    public function testOverviewMenuTest()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $response = $this->get('/api/menu');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                [
                    'type',
                    'items' => [
                        [
                            'id',
                            'menuNumber',
                            'addition',
                            'dish' => [
                                'id',
                                'name',
                                'price',
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }
}
