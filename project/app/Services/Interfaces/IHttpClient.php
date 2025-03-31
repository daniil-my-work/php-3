<?php

namespace App\Services\interfaces;

interface IHttpClient
{
    public function request(string $imdb_id);
}
