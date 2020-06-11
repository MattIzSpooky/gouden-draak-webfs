<?php

namespace Tests\Feature\Orders;

use App\User;
use App\UserRole;
use Carbon\Carbon;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class FilterTest extends TestCase
{
    /**
     * @group orders
     * @return void
     */
    public function testOrderOverviewFilter()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $data = [
            'from' => Carbon::create('2020-01-01T00:00:00')->toISOString(),
            'to' => Carbon::create('2020-12-01T00:00:00')->toISOString()
        ];

        $response = $this->get('/api/orders/filter?from=' . $data['from'] . '&to=' . $data['to']);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [[
                'id',
                'paidAt',
                'createdAt',
                'items' => [[
                    'id',
                    'menuNumber',
                    'addition',
                    'amount',
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
            ]]
        ]);
    }
}
