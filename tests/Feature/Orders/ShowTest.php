<?php

namespace Tests\Feature\Orders;

use App\User;
use App\UserRole;
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
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $response = $this->get('/api/orders/1');
        //dd($response->json());
        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'id',
                'paidAt',
                'items' => [[
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
                ]],
            ],
        ]);
    }
}
