<?php

namespace Tests\Feature\Discounts;

use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTest extends TestCase
{
    /**
     * @group discounts
     * @return void
     */
    public function testDeleteDiscountItemTest()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $response = $this->delete('/api/promotions/discounts/1');

        $response->assertStatus(200);

        $this->assertDatabaseMissing('promotional_discounts', ['id' => 1]);

        $this->assertDatabaseMissing('promotional_discounts_dishes', ['promotional_discounts_id' => 1]);
    }
}
