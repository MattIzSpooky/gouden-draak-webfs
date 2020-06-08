<?php

namespace Tests\Feature\Discounts;

use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    /**
     * @group discounts
     * @return void
     */
    public function testOverviewDiscounts()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $response = $this->get('/api/promotions/discounts');
        dd($response->json());
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                [
                    'type',
                    'items' => [
                        [
                            'id',
                            'menuNumber',
                            'addition',
                            'dish' => [
                                'id',
                                'name',
                                'price',
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }
}
