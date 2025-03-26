<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class MyCommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $film = Film::factory()->create();

        Comment::factory()->for($film)->create([
            "text" => "text 1",
            "rating" => 10,
        ]);

        Comment::factory()->for($film)->create([
            "text" => "text 2",
            "rating" => 9.9,
        ]);

        $film->refresh();
        $this->assertEquals(2, $film->comments->count());
    }
}
