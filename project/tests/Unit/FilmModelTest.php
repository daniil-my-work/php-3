<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $film = Film::factory()->create();

        Comment::factory()->create(['film_id' => $film->id, 'rating' => 10]);
        Comment::factory()->create(['film_id' => $film->id, 'rating' => 0]);

        $result = $film->getRatingAttribute();
        $this->assertEquals(5, $result);
    }
}
