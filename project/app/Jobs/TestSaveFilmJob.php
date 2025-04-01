<?php

namespace App\Jobs;

use App\Services\class\FilmService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TestSaveFilmJob implements ShouldQueue
{
    use Queueable;

    private string $imdb_id;

    /**
     * Create a new job instance.
     */
    public function __construct(string $imdb_id)
    {
        $this->imdb_id = $imdb_id;
    }

    public function getImdbId() {
        return $this->imdb_id;
    }

    /**
     * Execute the job.
     */
    public function handle(FilmService $filmService): void
    {
        $filmService->saveFilm($this->imdb_id);
    }
}
