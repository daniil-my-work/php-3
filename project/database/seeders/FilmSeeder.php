<?php

namespace Database\Seeders;

use App\Models\Film;
use Dom\Comment;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Film::factory()->count(50)->create();
    }
}
