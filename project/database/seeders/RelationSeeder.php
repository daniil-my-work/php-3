<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films = Film::all();
        $genres = Genre::all();
        $users = User::all();

        $films->each(function ($film) use ($genres) {
            $randomGenres = $genres->random(1);

            $film->genres()->attach($randomGenres->pluck('id'));
        });

        $films->each(function ($film) use ($users) {
            $film->users()->attach($users->random(1));
        });
    }
}
