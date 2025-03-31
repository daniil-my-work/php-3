<?php

namespace App\Services\class;

use App\Models\Film;
use App\Services\interfaces\IFilmService;
use App\Services\interfaces\IRepository;
use Illuminate\Support\Facades\Log;

class FilmService implements IFilmService
{
    private $repository;

    public function __construct(IRepository $repository)
    {
        $this->repository = $repository;
    }

    public function saveFilm(string $imdb_id)
    {
        $data = $this->getFilm($imdb_id);
        if (!is_array($data)) {
            Log::error('Некорректные данные для сохранения фильма', ['data' => $data]);
            throw new \InvalidArgumentException('Данные для сохранения фильма должны быть массивом.');
        }

        sleep(5); // Имитация задержки
        Film::create($data);
    }

    private function getFilm(string $imdb_id)
    {
        $result = $this->repository->getFilm($imdb_id);
        $filmData = json_decode($result, true);
        $preparedData = $this->prepareFilmData($filmData);
        return $preparedData;
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
