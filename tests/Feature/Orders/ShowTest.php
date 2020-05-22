<?php

namespace Tests\Feature\Orders;

use App\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class ShowTest extends TestCase
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

        $response = $this->get('/api/orders/1');
        //dd($response->json());
        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'id',
                'paid_at',
                'items' => [[
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
                ]],
            ],
        ]);
    }
}
