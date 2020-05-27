<?php

namespace Tests\Feature\News;

use App\News;
use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group news
     * @return void
     */
    public function testNewsDeleteCorrectTest()
    {
        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $news = factory(News::class)->create();

        $response = $this->delete('api/news/' . $news->id);

        $response->assertStatus(200);

        $this->assertSoftDeleted('news', ['id' => $news->id]);
    }

    /**
     * @group news
     * @return void
     */
    public function testNewsDeleteErrorTest()
    {
        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $response = $this->delete('api/news/' . 999999999);

        $response->assertStatus(404);
    }
}
