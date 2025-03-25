<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Film;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Film::factory()->count(10)->create();

        // Доделать
        Film::all()->each(function ($film) {
            $rootComments = Comment::factory()->count(rand(3, 8))->create(["film_id" => $film->id]);

            $rootComments->each(function ($rootComment) {
                Comment::factory()
                    ->count(rand(0, 5))
                    ->withParent($rootComment->id)
                    ->create(["film_id" => $rootComment->film_id]);
            });
        });
    }
}
