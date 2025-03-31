<?php

namespace App\Services\class;

use App\Models\Film;
use App\Services\interfaces\IFilmService;
use App\Services\interfaces\IRepository;

class FilmService implements IFilmService
{
    private $repository;

    public function __construct(IRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFilm(string $imdb_id)
    {
        $result = $this->repository->getFilm($imdb_id);
        $filmData = json_decode($result, true);
        return $filmData;
    }

    public function saveFilm($imdb_id)
    {
        $filmData = $this->getFilm($imdb_id);
        $preparedData = $this->prepareFilmData($filmData);

        if ($preparedData) {
            sleep(5);
            $film = Film::create($preparedData);
            var_dump("Фильм {$film->id} - {$film->name} успешно сохранен в БД.");
        } else {
            var_dump("Ошибка при получении данных о фильме");
        }
    }

    private function prepareFilmData(array $filmData): array
    {
        return [
            'name' => $filmData['Title'],
            'poster_image' => $filmData['Poster'],
            'description' => $filmData['Plot'],
            'director' => $filmData['Director'],
            'starring' => json_encode(explode(', ', $filmData['Actors'])), // Преобразование актёров в JSON
            'run_time' => (int) filter_var($filmData['Runtime'], FILTER_SANITIZE_NUMBER_INT), // Извлечение числа из строки
            'released' => (int) $filmData['Year'],
            'imdb_id' => $filmData['imdbID'],
        ];
    }
}
