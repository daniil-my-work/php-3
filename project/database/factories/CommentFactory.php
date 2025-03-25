<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->text(),
            'rating' => fake()->optional()->randomFloat(1, 0, 10),
            'film_id' => Film::inRandomOrder()->first()?->id ?? Film::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'parent_id' => null,
        ];
    }

    public function withParent($parentId = null)
    {
        return $this->state(function () use ($parentId) {
            return [
                'parent_id' => $parentId ?? Comment::inRandomOrder()->first()?->id,
            ];
        });
    }
}
