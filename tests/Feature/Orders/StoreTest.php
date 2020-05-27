<?php

namespace Tests\Feature\Orders;

use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

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
