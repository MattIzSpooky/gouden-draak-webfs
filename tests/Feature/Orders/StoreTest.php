<?php

namespace Tests\Feature\Orders;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    /**
     * @group orders
     * @return void
     */
    public function testStoreOrderTest()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        $data = [
            'paid_at' => null,
            'items' =>
            \json_encode([
                ['id' => 1, 'amount' => 1],
                ['id' => 2, 'amount' => 1],
                ['id' => 1, 'amount' => 5],
                ['id' => 2, 'amount' => 10],
                ['id' => 3, 'amount' => 2]
            ])

        ];

        $response = $this->post('/api/orders', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('orders', ['id' => $response['data']]);
    }
}
