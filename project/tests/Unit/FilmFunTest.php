<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmFunTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_get_films(): void
    {
        $genre = Genre::factory()->create([
            'name' => "ужасы",
        ]);
        $film = Film::factory()->create([
            'status' => 'pending'
        ]);
        $film->genres()->attach($genre->id);

        $query = [
            'limit' => 1,
            'page' => 1,
            'genre' => "ужасы",
            'status' => 'pending',
            'order_by' => 'released',
            'order_to' => 'asc',
        ];

        $link = '/api/films?' . http_build_query($query);
        $response = $this->getJson($link);

        // $response->dump();
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'films' => [],
                "limit",
                "page",
                "genre",
                "status",
                "order_by",
                "order_to"
            ]
        ]);

        $expectedFilm = $film->fresh()->toArray();
        $response->assertJson([
            "data" => [
                'films' => [$expectedFilm],
                'limit' => 1,
                'page' => 1,
                'genre' => "ужасы",
                'status' => 'pending',
                'order_by' => 'released',
                'order_to' => 'asc',
            ]
        ]);
    }

    public function test_get_similar_film()
    {
        $genre = Genre::factory()->create([
            'name' => "ужасы",
        ]);
        $films = Film::factory(5)->create();

        foreach ($films as $film) {
            $film->genres()->attach($genre->id);
        }

        $response = $this->getJson("/api/films/similar/{$films[0]->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'similar_films' => []
            ]
        ]);

        $similarFilms = Film::with('genres')
            ->where('id', '!=', $films[0]->id)
            ->get()
            ->toArray();
        $response->assertJson([
            'data' => [
                'similar_films' => $similarFilms
            ]
        ]);
    }

    public function test_get_film(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token')->plainTextToken;

        $genre = Genre::factory()->create([
            'name' => "ужасы",
        ]);
        $film = Film::factory()->create();
        $film->genres()->attach($genre->id);

        $response = $this
            ->withHeader('Authorization', "Bearer {$token}")
            ->getJson("api/films/{$film->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'film' => []
            ]
        ]);

        $film = $film->fresh(['genres']);

        $response->assertJsonFragment([
            'data' => [
                'film' => $film->toArray()
            ]
        ]);
    }
}
