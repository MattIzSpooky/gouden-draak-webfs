<?php

namespace Tests\Feature\News;

use App\News;
use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group news
     * @return void
     */
    public function testNewsUpdateCorrectTest()
    {
        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $news = factory(News::class)->create();
        $data  = ['title' => 'Test', 'text' => 'hello'];

        $response = $this->put('api/news/' . $news->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('news', $data);
        $this->assertDatabaseMissing('news', ['title' => $news]);
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

        $news = factory(News::class)->create();
        $data  = ['title' => '', 'text' => 'hello'];

        $response = $this->put('api/news/' . $news->id, $data);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('news', $data);
    }
}
