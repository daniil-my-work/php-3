<?php

namespace App\Jobs;

use App\Mail\SigmaEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Queueable;

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
        for ($i = 0; $i < 2; $i++) {
            sleep(5);
            Mail::to('dannil.suvorov.98@bk.ru')
                ->send(new SigmaEmail());
        }
    }
}
