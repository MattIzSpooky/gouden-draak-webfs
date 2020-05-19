<?php

namespace Tests\Feature\News;

use App\News;
use Tests\TestCase;
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
        $response = $this->delete('api/news/' . 999999999);

        $response->assertStatus(404);
    }
}
