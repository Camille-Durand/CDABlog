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

    public function getWeatherByCity(string $city): array{
        try{
            $data =$this->client->request(
                'GET',
                "https://api.openweathermap.org/data/2.5/weather?q=" .$city. "&appid=" .$this->apiKey,
            );

            if($data->getStatusCode() === 404) {
                throw new \Exception("Cette ville n'existe pas");
            }

            $response = $data->toArray();
            return $response;

        } catch (\Throwable $th) {
            return ["erreur" => $th->getMessage(), "cod" => 404];
        }
    }
}