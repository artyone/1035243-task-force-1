<?php


namespace frontend\controllers;

use frontend\models\Tasks;
use yii\web\Controller;
use frontend\models\TasksFilter;
use yii;
use yii\web\HttpException;


class TasksController extends Controller
{

    public function actionIndex()
    {
        $query = Tasks::find()
            ->orderBy('creation_time')
            ->where(['status' => Tasks::STATUS_NEW]);

        $model = new TasksFilter();
        $model->load(Yii::$app->request->get());

        foreach ($model as $key => $data) {
            if ($data) {
                switch ($key) {
                    case 'categories':
                        $query->andWhere(['tasks.category_id' => $data]);
                        break;
                    case 'noResponse':
                        $query->joinWith('tasksResponse');
                        $query->andWhere(['tasks_response.executor_id' => NULL]);
                        break;
                    case 'remoteWork':
                        $query->andWhere(['tasks.city_id' => NULL]);
                        break;
                    case 'period':
                        $query->andWhere(['>', 'tasks.creation_time', $model->getPeriodTime($data)]);
                        break;
                    case 'search':
                        $query->andWhere(['like','tasks.name',$data]);
                        break;
                }
            }
        }

        $tasks = $query
            ->all();

        return $this->render('index', [
            'tasks' => $tasks,
            'model' => $model

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