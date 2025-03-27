<?php

namespace Database\Factories;

use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    protected $model = Film::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'poster_image' => fake()->imageUrl(200, 200, 'movies', true),
            'preview_image' => fake()->imageUrl(200, 200, 'movies', true),
            'background_image' => fake()->imageUrl(1000, 400, 'nature', true),
            'background_color' => fake()->hexColor(),
            'video_link' => fake()->url(),
            'preview_video_link' => fake()->url(),
            'description' => fake()->paragraph(3),
            'director' => fake()->name(),
            'starring' => json_encode(fake()->randomElements([
                'Джейсон Стетхем',
                'Марго Роберт',
                'Роберт Дауни младший',
                'Том Круз',
            ], 3)),
            'run_time' => fake()->numberBetween(60, 240),
            'released' => fake()->year(),
            'promo' => fake()->boolean(50),
            'status' => fake()->randomElement([
                Film::STATUS_PENDING,
                Film::STATUS_ON_MODERATION,
                Film::STATUS_READY,
            ]),
            'imdb_id' => 'tt' . fake()->unique()->numerify('########'),
        ];
    }
}
