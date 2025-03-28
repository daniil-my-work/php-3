<?php

namespace App\Services\class;

use App\Services\interfaces\IRepository;
use Psr\Http\Client\ClientInterface;

class FilmRepository implements IRepository
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getFilm(string $imdb_id)
    {
        return $this->client->get($imdb_id);
    }
}
