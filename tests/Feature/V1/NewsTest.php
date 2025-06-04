<?php

namespace Tests\Feature\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_get_top_news()
    {
        $response = $this->getJson('/api/v1/news/top?country=us&q=tech');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'title',
                        'description',
                        'url',
                        'publishedAt',
                    ],
                ],
            ]);
    }
}
