<?php

namespace App\Jobs;

use App\Services\class\FilmService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Error;


class SaveFilmJob implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    private string $imdb_id;

    /**
     * Create a new job instance.
     */
    public function __construct(string $imdb_id)
    {
        $this->imdb_id = $imdb_id;
    }

    /**
     * Execute the job.
     */
    public function handle(FilmService $filmService): void
    {
        try {
            // throw new Error('тест');
            Log::info("Фильм с ID {$this->imdb_id} успешно сохранён.");
            $filmService->saveFilm($this->imdb_id);
        } catch (\Throwable $th) {
            Log::error(
                'Ошибка при сохранении фильма',
                [
                    'message' =>  $th->getMessage(),
                    'trace' =>  $th->getTraceAsString(),
                ]
            );
        }
    }
}
