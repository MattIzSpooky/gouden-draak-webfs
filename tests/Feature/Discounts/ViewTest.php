<?php

namespace Tests\Feature\Discounts;

use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class ViewTest extends TestCase
{
    /**
     * @group discounts
     * @return void
     */
    public function testViewOverviewDiscounts()
    {
        $this->artisan('migrate:fresh');
        $this->seed();

        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $response = $this->get('/api/promotions');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'title',
                    'text',
                    'validFrom',
                    'validTill',
                    'dishes' => [
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
            ]
        ]);
    }
}
