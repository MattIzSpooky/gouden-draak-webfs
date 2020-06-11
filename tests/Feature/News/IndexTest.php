<?php

namespace Tests\Feature\News;

use App\News;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        factory(News::class, 50)->create();
    }

    /**
     * @group news
     * @return void
     */
    public function testNewsCorrectTest()
    {
        $response = $this->get('api/news/');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [[
                'title',
                'text',
                'createdAt',
            ]],
            'links',
            'meta'
        ]);
    }
}
