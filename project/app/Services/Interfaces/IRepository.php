<?php

namespace App\Services\interfaces;

interface IRepository
{
    public function getFilm(string $imdb_id);
}
