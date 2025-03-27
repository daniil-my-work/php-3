<?php

namespace Tests\Unit;

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenreFunTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $genres = Genre::factory(2)->create();

        $response = $this->get('/api/genres');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['genres' => []]]);
        $response->assertJsonCount($genres->count(), 'data.genres');
    }
}
