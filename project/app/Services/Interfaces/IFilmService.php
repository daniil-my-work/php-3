<?php

namespace App\Services\interfaces;

use App\Models\Film;

interface IFilmService
{
    // public function getFilm(string $imdb_id);
    public function saveFilm(Film $filmData);
}
