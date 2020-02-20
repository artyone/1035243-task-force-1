<?php


namespace frontend\controllers;

use frontend\models\Tasks;
use yii\web\Controller;


class TasksController extends Controller
{
    const STATUS_NEW = 1;
    const STATUS_EXECUTION = 2;
    const STATUS_CANCELED = 3;
    const STATUS_FAILED = 4;
    const STATUS_DONE = 5;

    public function actionIndex()
    {
        $query = Tasks::find();

        $tasks = $query->orderBy('creation_time')
            ->where(['status' => self::STATUS_NEW])
            ->all();

        return $this->render('index', [
            'tasks' => $tasks
        ]);
    }

}