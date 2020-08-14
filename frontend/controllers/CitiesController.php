<?php


namespace frontend\controllers;

use frontend\models\Cities;
use http\Client;
use yii\data\Pagination;
use yii\web\Controller;
use frontend\service\YandexMaps;


class CitiesController extends Controller
{

    public function actionIndex()
    {
        $query = Cities::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $cities = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $query = 'Санкт-Петербург, проспект Космонавтов, дом 29';
/*        $apiKey = 'e666f398-c983-4bde-8f14-e3fec900592a';
        $client = new Client(['base_uri' => 'https://geocode-maps.yandex.ru/1.x/']);
        $response = $client->request('GET', '', [
            'proxy' => ['https' => 'http://LSR\Tihonov.AN:Ebwy4712@p-proxy.lsr.ru:3128'],
            'query' => ['apikey' => $apiKey,
                'geocode' => $query,
                'format' => 'json',
                'results' => 20]
        ]);

        $content = $response->getBody()->getContents();
        $result = json_decode($content, true);*/
        $request = new YandexMaps();
        $coordinates = $request->getCoordinate($query);
        $result = $request->getObject($coordinates);


        return $this->render('index', [
            'cities' => $cities,
            'pagination' => $pagination,
            'result' => $coordinates
        ]);
    }

}