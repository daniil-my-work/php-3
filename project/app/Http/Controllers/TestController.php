<?php

namespace App\Http\Controllers;

use App\Jobs\SaveFilmJob;
use App\Jobs\SendMailJob;
use App\Mail\SigmaEmail;
use App\Models\Film;
use App\Services\class\client\LaravelHttpClient;
use App\Services\class\FilmRepository;
use App\Services\class\FilmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    // Цель 8.5+/10
    // Раунд 1: 6/10
    // Раунд 2: 5/10
    // Раунд 3: 6/10
    // Раунд 4: 6.5/10
    // Раунд 5: 6/10
    // Раунд 6: 8.5/10 +++ (Простые выражения пройдены)

    // Раунд 1: 5/10 (связи)
    // Раунд 2: 4/10 (связи)
    // Раунд 3: 6/10 (связи)
    // Раунд 4: 6.5/10 (связи) УРА.

    public function test() {}

    public function storeFilm(Request $request)
    {
        // 1. Сохранение без очереди напрямую
        $client = new LaravelHttpClient();
        $filmsRepository = new FilmRepository($client);
        $filmService = new FilmService($filmsRepository);
        $film = $filmsRepository->getFilm($request->id);
        $filmService->saveFilm($film);

        // 2. Сохранение при помощи очереди
        // SaveFilmJob::dispatch($request->id);
        // return $this->success(['message' => "Задача на сохранение фильма {$request->id} отправлена в очередь."], 201);
    }

    public function sendMail()
    {
        // 1. Отправка без очереди напрямую
        // for ($i = 0; $i < 5; $i++) {
        //     sleep(3);
        //     Mail::to('dannil.suvorov.98@bk.ru')
        //         ->send(new SigmaEmail());
        // }

        // 2. Отправка при помощи очереди
        SendMailJob::dispatch()->onQueue('email');

        $now = date('d-m-Y H:i:s');
        echo "Письма успешно отправлены. {$now}";
    }
}
