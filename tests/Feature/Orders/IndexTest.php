<?php

namespace Tests\Feature\Orders;

use App\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class IndexTest extends TestCase
{
    /**
     * @group orders
     * @return void
     */
    public function testOrderOverviewTest()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->get('/api/orders');

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [[
                'id',
                'paid_at',
                'items' => [[
                    'id',
                    'menu_number',
                    'addition',
                    'amount',
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
                ]],
            ]],
            'links',
            'meta'
        ]);
    }
}
