<?php

namespace App\Http\Controllers;

use App\Jobs\SaveFilmJob;
use App\Models\Film;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        $result = Film::find(1)->getRatingAttribute();
        var_dump($result);
        // return $result;
    }

    public function storeFilm(Request $request)
    {
        SaveFilmJob::dispatch($request->id);
        return $this->success(['message' => "Задача на сохранение фильма {$request->id} отправлена в очередь."], 201);
    }
}
