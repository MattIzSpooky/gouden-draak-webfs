<?php

namespace Tests\Feature\News;

use App\News;
use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group news
     * @return void
     */
    public function testNewsStoreCorrectTest()
    {
        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $data  = ['title' => 'Test', 'text' => 'this is a test'];

        $response = $this->post('api/news/', $data);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => [
                'title',
                'text',
                'created_at',
            ]
        ]);

        $this->assertDatabaseHas('news', $data);
    }

    /**
     * @group news
     * @return void
     */
    public function testNewsStoreValidationErrorTest()
    {
        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $data  = ['title' => '', 'text' => 'this is a test'];

        $response = $this->post('api/news/', $data);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('news', $data);
    }
}
