<?php

namespace Tests\Feature\News;

use App\News;
use Tests\TestCase;
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
        $data  = ['title' => '', 'text' => 'this is a test'];

        $response = $this->post('api/news/', $data);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('news', $data);
    }
}
