<?php


namespace frontend\service;


class YandexMaps extends HttpService
{
    const URI = 'https://geocode-maps.yandex.ru/1.x';
    const API_KEY = 'e666f398-c983-4bde-8f14-e3fec900592a';

    const LOG_FILE = 'logs/logs.txt';

    public function getCoordinate($address)
    {
        $params = [
            'geocode' => $address,
            'results' => 1
        ];
        $body = $this->createBody($params);
        $response = $this->sendRequest($body);
        foreach ($response->getResultData() as $data) {
            $coordinates = $data['GeoObject']['Point']['pos'];
        }
        $coordinates = explode(' ', $coordinates);
        $coordinates = ['latitude' => $coordinates[1], 'longitude' => $coordinates[0]];
        return $coordinates;
    }

    public function getObject($coordinates)
    {
        $params = [
            'geocode' => $coordinates['longitude'] . ', ' . $coordinates['latitude'],
            'kind' => 'house',
            'results' => 1
        ];
        $body = $this->createBody($params);
        $response = $this->sendRequest($body);
        foreach ($response->getResultData() as $data) {
            $object = $data['GeoObject']['name'];
        }
        return $object;
    }

    protected function createBody($params = [])
    {
        $body = array_merge([
            'apikey' => self::API_KEY,
            'format' => 'json'
        ], $params);
        return $body;
    }


}