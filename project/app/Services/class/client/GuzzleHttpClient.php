<?php

namespace App\Services\class\client;

use App\Services\interfaces\IHttpClient;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GuzzleHttpClient implements IHttpClient
{
    private $apiKey = 'eaa28f6';

    public function request(string $imdb_id)
    {
        try {
            $client = new Client();
            $response = $client->request("GET", "http://www.omdbapi.com/?apikey={$this->apiKey}&i={$imdb_id}");

            if ($response->getStatusCode() !== 200) {
                throw new Exception("Error HTTP request {$response->getStatusCode()}");
            }

            return $response->getBody()->getContents();
        } catch (\Throwable $th) {
            Log::error('Error fetching fim', $th->getMessage());
            return null;
        }
    }
}
