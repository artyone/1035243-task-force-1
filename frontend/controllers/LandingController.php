<?php


namespace frontend\controllers;


use yii\web\Controller;
use frontend\models\Tasks;

/**
 * Landing controller
 */
class LandingController extends Controller
{
    /**
     * Отображение лэндинга сайта
     *
     * @return mixed
     */
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