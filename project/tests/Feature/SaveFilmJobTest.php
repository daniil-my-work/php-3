<?php

namespace Tests\Feature;

use App\Jobs\SaveFilmJob;
use App\Models\Film;
use App\Services\class\FilmRepository;
use App\Services\class\FilmService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Mockery\MockInterface;
use Tests\TestCase;

class SaveFilmJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_save_film_job_is_pushed_to_queue(): void
    {
        // Проверка добавления задачи
        Queue::fake();

        // Добавляем задачу в очередь
        SaveFilmJob::dispatch('tt0111161');

        // Проверяем, что задача была добавлена в очередь
        Queue::assertPushed(SaveFilmJob::class, function ($job) {
            return $job->getImdbId() === 'tt0111161';
        });
    }

    public function test_save_film_job_saves_data_to_database(): void
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
        $filmMockRepository = $this->mock(FilmRepository::class, function (MockInterface $mock) use ($filmData) {
            $mock->shouldReceive('getFilm')->once()->with('tt12345')->andReturn(json_encode($filmData));
        });

        $filmService = new FilmService($filmMockRepository);
        (new SaveFilmJob('tt12345'))->handle($filmService);

        $this->assertDatabaseHas('films', [
            'imdb_id' => 'tt12345',
            'name' => 'Тест'
        ]);
    }
}
