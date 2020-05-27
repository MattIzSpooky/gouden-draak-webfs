<?php

namespace Tests\Feature\News;

use App\News;
use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group news
     * @return void
     */
    public function testNewsShowCorrectTest()
    {
        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $news = factory(News::class)->create();

        $response = $this->get('api/news/' . $news->id);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'title',
                'text',
                'created_at',
            ]
        ]);
    }

    /**
     * @group news
     * @return void
     */
    public function testNewsShowInCorrectTest()
    {
        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $response = $this->get('api/news/' . 9999999999);

        $response->assertStatus(404);
    }
}
