<?php


namespace frontend\controllers;

use frontend\models\Cities;
use yii\data\Pagination;
use yii\web\Controller;


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

        return $this->render('index', [
            'cities' => $cities,
            'pagination' => $pagination,
        ]);
    }

}