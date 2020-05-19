<?php

namespace Tests\Feature\News;

use App\News;
use Tests\TestCase;
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
        $news = factory(News::class)->create();
        $data  = ['title' => '', 'text' => 'hello'];

        $response = $this->put('api/news/' . $news->id, $data);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('news', $data);
    }
}
