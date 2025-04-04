<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CommentSeeder::class,
            FilmSeeder::class,
            GenreSeeder::class,
            RelationSeeder::class,
            UserSeeder::class,
            RoleSeeder::class
        ]);
    }
}
