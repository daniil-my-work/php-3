<?php

namespace Tests\Feature;

use App\Jobs\TestSaveFilmJob;
use App\Models\Film;
use App\Services\class\FilmRepository;
use App\Services\class\FilmService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Mockery\MockInterface;
use Tests\TestCase;

class TetsSaveFilmTest extends TestCase
{
    use RefreshDatabase;


    public function test_pushed_film_in_queue(): void
    {
        Queue::fake();

        TestSaveFilmJob::dispatch('tt12345');

        Queue::assertPushed(TestSaveFilmJob::class, function (TestSaveFilmJob $job) {
            return $job->getImdbId() === 'tt12345';
        });
    }

    public function test_saved_film_to_db(): void
    {
        $filmData = [
            'imdbID' => 'tt12345',
            'Title' => 'Тест',
            'Poster' => 'http://test.ru',
            'Plot' => 'http://test.ru',
            'Director' => 'Anna',
            'Actors' => json_encode(["anna", "daniil"]), // Преобразование актёров в JSON
            'Runtime' => 20, // Извлечение числа из строки
            'Year' => 2025,
        ];

        /** @var FilmRepository $filmMockRepository */
        $filmMockRepository = $this->mock(FilmRepository::class, function(MockInterface $mock) use ($filmData) {
            $mock->shouldReceive('getFilm')->once()->with('tt12345')->andReturn(json_encode($filmData));
        });

        $filmService = new FilmService($filmMockRepository);
        (new TestSaveFilmJob('tt12345'))->handle($filmService);

        $this->assertDatabaseHas('films', [
            'imdb_id' => 'tt12345',
            'name' => 'Тест'
        ]);
    }
}
