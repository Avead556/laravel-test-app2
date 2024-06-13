<?php

namespace App\Repository;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

readonly class CurrencyRepository
{
    public function __construct(private Client $client)
    {
    }

    public function getCurrencies()
    {
        try {
            $response = $this->client->get('latest/USD');
        } catch (\Throwable $e) {
            Log::critical('CURRENCY REQUEST] error:' . $e->getMessage());
            return [];
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}
