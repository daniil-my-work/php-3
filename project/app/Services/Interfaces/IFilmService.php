<?php

namespace App\Services\interfaces;

interface IFilmService
{
    public function getFilm(string $imdb_id);
}
