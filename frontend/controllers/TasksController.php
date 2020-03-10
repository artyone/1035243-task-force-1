<?php


namespace frontend\controllers;

use frontend\models\Tasks;
use yii\web\Controller;
use yii\data\Pagination;
use frontend\models\TasksFilter;
use yii;
use yii\web\HttpException;


class TasksController extends Controller
{

    public function actionIndex()
    {
        $query = Tasks::find()
            ->orderBy(['creation_time' => SORT_DESC])
            ->where(['status' => Tasks::STATUS_NEW]);

        $model = new TasksFilter();
        if (Yii::$app->request->get()) {
            $model->load(Yii::$app->request->get());
        }

        $query = $model->applyFilters($query);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);
        $query->offset($pagination->offset);
        $query->limit($pagination->limit);

        $tasks = $query
            ->all();

        return $this->render('index', [
            'tasks' => $tasks,
            'model' => $model,
            'pagination' => $pagination,

        ]);
    }

    public function actionView($id)
    {
        $task = Tasks::findOne($id);

        if (!$task) {
            throw new HttpException(404 ,'Task not found');
        }

        return $this->render('view', [
            'task' => $task

        ]);
    }


}