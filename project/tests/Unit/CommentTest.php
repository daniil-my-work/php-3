<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Film;
use App\Models\Role;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
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

    #[Group('functional')]
    public function test_update_comment(): void
    {
        $moderatorRole = Role::create(['role_name' => 'Модератор', 'role_value' => 'moderator']);

        $user = User::factory()
            ->hasAttached($moderatorRole)
            ->create();
        $token = $user->createToken('auth-token')->plainTextToken;

        $comment = Comment::factory()->create([
            "text" => "Текст",
            "rating" => "1",
        ]);

        $response = $this
            ->withHeaders([
                'Authorization' => "Bearer {$token}"
            ])
            ->patchJson("/api/comments/{$comment->id}", [
                "text" => "Новый текст",
                "rating" => "9",
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'message',
                'comment' => []
            ]
        ]);

        $response->assertJsonPath('data.comment.text', 'Новый текст');
        $response->assertJsonPath('data.comment.rating', 9);

        // $updatedComment = $comment->fresh();
        // $response->assertJsonFragment([
        //     "data" => [
        //         "message" => "Комментарий {$comment->id} успешно отредактирован",
        //        "comment" => [
        //         "id" => $updatedComment->id,
        //         "text" => $updatedComment->text,
        //         "rating" => $updatedComment->rating,
        //         "parent_id" => $updatedComment->parent_id,
        //         "created_at" => $updatedComment->created_at->toJSON(),
        //         "author" => $updatedComment->author,
        //     ],
        //     ]
        // ]);
    }

    #[Group('functional')]
    public function test_destroy_comment(): void
    {
        // Вариант 1
        $moderatorRole = Role::create(['role_name' => 'Модератор', 'role_value' => 'moderator']);
        $user = User::factory()
            ->hasAttached($moderatorRole)
            ->create();

        Sanctum::actingAs($user);

        $comment = Comment::factory()->create();
        $response = $this->deleteJson(route('comments.destroy', $comment->id));

        // Вариант 2
        // $moderatorRole = Role::create(['role_name' => 'Модератор', 'role_value' => 'moderator']);
        // $user = User::factory()
        //     ->hasAttached($moderatorRole)
        //     ->create();
        // $token = $user->createToken('auth-token')->plainTextToken;

        // $comment = Comment::factory()->create();
        // $response = $this
        //     ->withHeaders([
        //         'Authorization' => "Bearer {$token}"
        //     ])
        //     ->deleteJson("/api/comments/{$comment->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'message'
            ]
        ]);

        $response->assertJsonPath(
            'data.message',
            "Комментарий {$comment->id} успешно удален"
        );

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id
        ]);
    }
}
