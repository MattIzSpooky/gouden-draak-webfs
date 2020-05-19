<?php

namespace Tests\Feature\News;

use App\News;
use Tests\TestCase;
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
        $response = $this->get('api/news/' . 9999999999);

        $response->assertStatus(404);
    }
}
