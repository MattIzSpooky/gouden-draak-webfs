<?php

namespace Tests\Feature\Discounts;

use App\Dish;
use App\User;
use App\UserRole;
use Carbon\Carbon;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTest extends TestCase
{
    /**
     * @group discounts
     * @return void
     */
    public function testUpdateDiscountsTest()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $data = [
            'title' => 'NEEEEE',
            'text' => 'HAHAHAHhah hahahhaha hahahha hahahha hahaha',
            'validFrom' => Carbon::now()->toISOString(),
            'validTill' => Carbon::now()->addDays(100)->toISOString(),
            'price' => 14.99,
            'dishes' => Dish::all()->random(1)->pluck('id')->toArray()
        ];

        $response = $this->put('/api/promotions/discounts/1', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('promotional_discounts', [
            'title' => $data['title'],
            'valid_till' => Carbon::parse($data['validTill'])->toDateString(),
            'price' => $data['price']
        ]);
    }
}
