<?php

namespace App\Console\Commands;

use App\Jobs\SaveFilmsJob;
use Illuminate\Console\Command;

class ProcessPendingFilms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'films:process-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process pending films by dispatching SaveFilmsJob';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        SaveFilmsJob::dispatch();
        $this->info('Задача на обработку фильмов отправлена в очередь.');
    }
}
