<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Services\class\FilmRepository;
use App\Services\class\FilmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        // $result = Film::find(100)->scores()->get()->toArray();
        $result = Film::find(1)->getRatingAttribute();
        var_dump($result);
        // return $result;
    }

    public function storeFilm()
    {
        $client = new Http();

        $repository = new FilmRepository($client);
        $filmService = new FilmService($repository);
        $result = $filmService->getFilm('123');
        return $result;
    }
}
