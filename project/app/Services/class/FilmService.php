<?php

namespace App\Services\class;

use App\Models\Film;
use App\Services\interfaces\IFilmService;
use App\Services\interfaces\IRepository;
use Illuminate\Support\Facades\Log;

class FilmService implements IFilmService
{
    // private $repository;

    // public function __construct(IRepository $repository)
    // {
    //     $this->repository = $repository;
    // }

    // public function getFilm(string $imdb_id)
    // {
    //     $result = $this->repository->getFilm($imdb_id);
    //     return $result;
    // }

    public function saveFilm($data)
    {
        if (!is_array($data)) {
            Log::error('Некорректные данные для сохранения фильма', ['data' => $data]);
            throw new \InvalidArgumentException('Данные для сохранения фильма должны быть массивом.');
        }

        sleep(5); // Имитация задержки
        Film::create($data);
    }
}
