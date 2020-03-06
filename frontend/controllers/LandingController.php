<?php


namespace frontend\controllers;


use yii\web\Controller;
use frontend\models\Tasks;

class LandingController extends Controller
{
    public function actionIndex()
    {
        $query = Tasks::find()
            ->orderBy(['creation_time' => SORT_DESC])
            ->where(['status' => Tasks::STATUS_NEW])
            ->limit(4);

        $tasks = $query->all();

        return $this->renderPartial('index', [
            'tasks' => $tasks,
        ]);
    }
}