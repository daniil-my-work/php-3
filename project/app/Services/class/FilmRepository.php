<?php

namespace App\Services\class;

use App\Services\interfaces\IHttpClient;
use App\Services\interfaces\IRepository;

class FilmRepository implements IRepository
{
    private $httpClient;

    public function __construct(IHttpClient $client)
    {
        $this->httpClient = $client;
    }

    public function getFilm(string $imdb_id)
    {
        $result = $this->httpClient->request($imdb_id);
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
