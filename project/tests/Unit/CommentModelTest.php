<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\TestCase;

class CommentModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_comment(): void
    {
        // $this->assertTrue(true);

        // $user = User::create([
        //     'name' => 'Тестовое имя',
        //     'email' => 'test@mail.ru',
        //     'password' => Hash::make('123456'),
        // ]);

        $user = User::factory()->create([
            'name' => 'Тестовое имя',
        ]);

        $comment = Comment::factory()->create();
        $user->comments()->save($comment);

        
    }
}
