<?php

namespace App\Jobs;

use App\Models\Film;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SaveFilmsJob implements ShouldQueue
{
    use Queueable, SerializesModels, Dispatchable, InteractsWithQueue;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Film::where('status', Film::STATUS_PENDING)->chunk(1000, function ($films) {
            foreach ($films as $film) {
                SaveFilmJob::dispatch($film->id);
            }
        });

        Log::info('Все фильмы со статусом "pending" были отправлены в очередь.');
    }
}
