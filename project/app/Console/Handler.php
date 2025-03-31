<?php

namespace App\Console;

use App\Console\Commands\ProcessPendingFilms;
use Illuminate\Console\Scheduling\Schedule;

class Handler
{
    public function __invoke(Schedule $schedule): void
    {
        $schedule->command(ProcessPendingFilms::class)->dailyAt('13:00');
        // $schedule->command(ProcessPendingFilms::class)->everyMinute();
    }
}
