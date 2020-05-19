<?php

namespace Tests\Feature\DishType;

use App\User;
use UserSeeder;
use DishTypeSeeder;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group dish
     * @return void
     */
    public function testDishTypeOverviewTest()
    {
        $this->seed(UserSeeder::class);
        $this->seed(DishTypeSeeder::class);

        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->get('api/dish/types');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'type'
                ]
            ]
        ]);
    }
}
