<?php

namespace App\Services;

class WeatherService
{
    private string $api_key;

    public function __construct()
    {
        $this->api_key = config('services.weather.api_key');
    }

    public function getWeather(string $city)
    {
        return \Http::get('https://api.weatherapi.com/v1/current.json', [
            'key' => $this->api_key,
            'q' => $city,
            'aqi' => 'no',
        ])->object();
    }
}
