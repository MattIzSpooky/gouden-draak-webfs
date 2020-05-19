<?php

namespace Tests\Feature\MenuAddition;

use App\User;
use UserSeeder;
use Tests\TestCase;
use MenuAdditionSeeder;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group menu
     * @return void
     */
    public function testOverviewExample()
    {
        $this->seed(UserSeeder::class);
        $this->seed(MenuAdditionSeeder::class);

        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->get('api/dish/additions');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                ['addition']
            ]
        ]);
    }
}
