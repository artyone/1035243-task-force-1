<?php


namespace frontend\controllers;

use frontend\models\Tasks;
use yii\web\Controller;
use frontend\models\TasksFilter;
use yii;


class TasksController extends Controller
{

    public function actionIndex()
    {
        $query = Tasks::find()
            ->orderBy('creation_time')
            ->where(['status' => Tasks::STATUS_NEW]);

        $model = new TasksFilter();
        $model->load($_GET);

        foreach ($model as $key => $data) {
            if ($data) {
                switch ($key) {
                    case 'categories':
                        $query->andWhere(['category_id' => $data]);
                        break;
                    case 'noResponse':
                        $query->joinWith('taskResponses');
                        $query->andWhere(['tasks_responses.executor_id' => NULL]);
                        break;
                    case 'remoteWork':
                        $query->andWhere(['latitude' => NULL]);
                        break;
                    case 'period':
                        $query->andWhere(['>', 'creation_time', $model->getPeriodTime($data)]);
                        break;
                    case 'search':
                        $query->andWhere(['like','name',$data]);
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

}