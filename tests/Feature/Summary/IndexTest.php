<?php

namespace Tests\Feature\Summary;

use App\User;
use App\UserRole;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    /**
     * @group summary
     * @return void
     */
    public function testExample()
    {
        Sanctum::actingAs(
            factory(User::class)->create(['user_role_id' => UserRole::ADMIN]),
            ['*']
        );

        $response = $this->get('/api/summary/');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                [
                    'date',
                    'file'
                ]
            ]
        ]);
    }
}
