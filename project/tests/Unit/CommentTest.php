<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Film;
use App\Models\User;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

class CommentTest extends TestCase
{
    #[Group('functional')]
    public function test_get_comments(): void
    {
        $film = Film::factory()->create();
        Comment::factory()
            ->count(3)
            ->for($film)
            ->create();

        // $film = Film::factory()
        //     ->has(Comment::factory()->count(3))
        //     ->create();

        $response = $this->getJson("/api/comments/{$film->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'comments' => []
            ]
        ]);
        $response->assertJsonCount(3, 'data.comments');
    }

    #[Group('functional')]
    public function test_create_comment(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token')->plainTextToken;
        $film = Film::factory()->create();

        $response = $this
            ->withHeaders([
                'Authorization' => "Bearer {$token}"
            ])
            ->postJson("/api/comments/{$film->id}", [
                "text" => "Очень длинный комментрарий. Очень длинный комментрарий. Очень длинный комментрарий. Очень длинный комментрарий.",
                "rating" => "9",
                "comment_id" => "50",
                "film_id" => "1"
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'message',
                'film' => []
            ]
        ]);
        $response->assertJsonCount(1, "data.film");
    }

    // role_value
}
