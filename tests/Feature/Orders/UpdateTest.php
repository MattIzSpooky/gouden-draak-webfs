<?php

namespace Tests\Feature\Orders;

use App\Order;
use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTest extends TestCase
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
            'items' => [
                ['id' => 1, 'amount' => 1],
                ['id' => 2, 'amount' => 1],
                ['id' => 1, 'amount' => 5],
                ['id' => 2, 'amount' => 10],
                ['id' => 3, 'amount' => 2]
            ]
        ];

        $order = Order::find(1);

        $response = $this->put('/api/orders/' . $order->id, $data);

        $response->assertOk();

        $this->assertDatabaseHas('orders', ['id' => $response['data']]);
    }
}
