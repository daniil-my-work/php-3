<?php

namespace App\Services\class;

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
        return $this->repository->getFilm($imdb_id);
    }
}
