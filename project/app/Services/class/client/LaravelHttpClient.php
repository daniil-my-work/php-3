<?php

namespace App\Services\class\client;

use App\Services\interfaces\IHttpClient;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class LaravelHttpClient implements IHttpClient
{
    private $apiKey = 'eaa28f6';

    public function request(string $imdb_id)
    {
        try {
            $response = Http::get("http://www.omdbapi.com/?apikey={$this->apiKey}&i={$imdb_id}");

            if ($response->failed()) {
                throw new Exception("HTTP request failed");
            }

            return $response->body();
        } catch (Throwable $th) {
            Log::error('Error fetching film', $th->getMessage());
            return null;
        }
    }
}
