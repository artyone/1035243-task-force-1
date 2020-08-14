<?php


namespace frontend\controllers;

use frontend\models\Cities;
use http\Client;
use yii\data\Pagination;
use yii\web\Controller;
use frontend\service\YandexMaps;
use yii\web\HttpException;
use yii;


class AjaxController extends Controller
{

    public function actionIndex()
    {
        $get = Yii::$app->request->get();
        if ($get['getAddress']) {
            return (new YandexMaps())->getCoordinate($get['getAddress']);
        }
        return [];

    }

}