<?php

namespace Tests\Feature\Menu;

use App\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    /**
     * @group menu
     * @return void
     */
    public function testOverviewMenuTest()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->get('/api/menu');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                [
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
            ]
        ]);
    }
}
