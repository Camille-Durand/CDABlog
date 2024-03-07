<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService{
    private HttpClientInterface $client;

    private string $apiKey;

    public function __construct($apiKey, HttpClientInterface $client){
        $this->apiKey = $apiKey;

        $this->client = $client;
    }

    public function getWeather(): array{
        $response = $this->client->request(
            'GET',
            'https://api.openweathermap.org/data/2.5/weather?lon=1.44&lat=43.6&appid=' . $this->apiKey
        );

        $response = $response->toArray();
        return $response;
    }
}