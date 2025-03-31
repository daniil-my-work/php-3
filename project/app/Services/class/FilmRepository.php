<?php

namespace App\Services\class;

use App\Services\class\client\LaravelHttpClient;
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
        return $this->httpClient->request($imdb_id);
    }
}
