<?php

namespace Tests\Feature\Orders;

use App\Table;
use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class StoreCustomerTest extends TestCase
{
    /**
     * @group orders
     * @return void
     */
    public function testStoreOrderTest()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $data = [
            'paidAt' => null,
            'tableId' => Table::find(1)->id,
            'items' => [
                ['id' => 1, 'amount' => 1],
                ['id' => 2, 'amount' => 1],
                ['id' => 1, 'amount' => 5],
                ['id' => 2, 'amount' => 10],
                ['id' => 3, 'amount' => 2]
            ]
        ];

        $response = $this->post('/api/table/orders', $data);

        $response->assertStatus(302);
    }
}
