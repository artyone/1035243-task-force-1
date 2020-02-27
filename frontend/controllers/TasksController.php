<?php


namespace frontend\controllers;

use frontend\models\Tasks;
use yii\web\Controller;
use frontend\models\TasksFilter;


class TasksController extends Controller
{

    public function actionIndex()
    {
        $query = Tasks::find();

        $tasks = $query->orderBy('creation_time')
            ->where(['status' => Tasks::STATUS_NEW])
            ->all();

        $model = new TasksFilter();

        return $this->render('index', [
            'tasks' => $tasks,
            'model' => $model

        ]);
    }

}