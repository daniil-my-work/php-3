<?php

namespace Tests\Unit;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_genre(): void
    {
        $genres = Genre::factory(2)->create();

        $response = $this->getJson('/api/genres');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['genres' => []]]);
        $response->assertJsonCount($genres->count(), 'data.genres');
    }

    public function test_update_genre()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token')->plainTextToken;

        $genre = Genre::factory()->create(['name' => 'боевик']);
        $newData = ['name' => 'комедия'];

        $response = $this->withHeaders([
            "Authorization" => "Bearer {$token}"
        ])->patchJson("/api/genres/{$genre->id}", $newData);
        // $response->dump();

        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'data' => [
                    'message',
                    'genre' => []
                ]
            ]
        );
        $response->assertJsonFragment(['name' => 'комедия']);
        $this->assertDatabaseHas('genres', [
            'id' => $genre->id,
            'name' => 'комедия'
        ]);
    }
}
