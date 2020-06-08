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

class StoreTest extends TestCase
{
    /**
     * @group discounts
     * @return void
     */
    public function testStoreDiscountsTest()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $data = [
            'title' => 'Hello',
            'text' => 'HAHAHAHhah hahahhaha hahahha hahahha hahaha',
            'validFrom' => Carbon::now()->toISOString(),
            'validTill' => Carbon::now()->addDays(15)->toISOString(),
            'price' => 14.99,
            'dishes' => Dish::all()->random(2)->pluck('id')->toArray()
        ];

        $response = $this->post('/api/promotions/discounts', $data);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'text',
                'validFrom',
                'validTill',
                'dish' => [
                    [
                        'id',
                        'name',
                        'price',
                        'dishType' => [
                            'id',
                            'type'
                        ]
                    ]
                ]
            ]
        ]);

        $this->assertDatabaseHas('promotional_discounts', [
            'title' => $data['title'],
            'valid_from' => Carbon::parse($data['validFrom'])->toDateString(),
            'price' => $data['price']
        ]);
    }

    /**
     * @group discounts
     * @return void
     */
    public function testStoreDiscountsWithErrorsTest()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $data = [
            'title' => 'Hello',
            'text' => '',
            'validFrom' => Carbon::now()->toIso8601String(),
            'validTill' => Carbon::now()->addDays(15)->toISOString(),
            'price' => 14.9999999,
            'dishes' => null
        ];

        $response = $this->post('/api/promotions/discounts', $data);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('promotional_discounts', [
            'title' => $data['title'],
            'valid_from' => Carbon::parse($data['validFrom'])->toDateString(),
            'price' => $data['price']
        ]);
    }
}
