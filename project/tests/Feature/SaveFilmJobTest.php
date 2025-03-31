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
        // Проверка добавления записи в БД
        $film = Film::factory()->create([
            "imdb_id" => 'tt0111161',
            'name' => 'Test Movie',
        ]);

        /** @var FilmRepository $filmRepository */
        $filmRepository = $this->mock(FilmRepository::class, function (MockInterface $mock) use ($film) {
            $mock->shouldReceive('getFilm')->once()->with('tt0111161')->andReturn($film);
        });

        // Используем реальный FilmService
        $filmService = new FilmService($filmRepository);

        /** @var FilmService $filmService */
        (new SaveFilmJob('tt0111161'))->handle($filmRepository, $filmService);

        // Проверка, что фильм был добавлен в БД
        $this->assertDatabaseHas('films', [
            'imdb_id' => 'tt0111161',
            'name' => 'Test Movie',
        ]);
    }
}
