<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_comment(): void
    {
        // Создаем пользователя
        $user = User::factory()->create([
            'email' => 'test@mail.ru',
        ]);

        // Создаем комментарий
        $film = Film::factory()->create();
        $comment = new Comment([
            'text' => "ТЕСТ. Новый комментарий",
            'rating' => 10,
            'film_id' => $film->id,
        ]);

        // Привязываем комментарий к пользователю
        $user->comments()->save($comment);

        // Находим сохраненный комментарий
        $newComment = Comment::where('text', 'ТЕСТ. Новый комментарий')->first();

        // Проверяем, что комментарий привязан к правильному пользователю
        $this->assertEquals($newComment->user_id, $user->id);
    }
}
