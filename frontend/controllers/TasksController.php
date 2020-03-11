<?php


namespace frontend\controllers;

use frontend\models\Tasks;
use yii\web\Controller;
use yii\data\Pagination;
use frontend\models\TasksFilterForm;
use yii;
use yii\web\HttpException;

/**
 * Tasks controller
 */
class TasksController extends Controller
{
    /**
     * Отображение общего списка заданий с учетом фильтров, если они заданы.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Tasks::find()
            ->orderBy(['creation_time' => SORT_DESC])
            ->where(['status' => Tasks::STATUS_NEW]);

        $tasksFilterForm = new TasksFilterForm();
        if (Yii::$app->request->get()) {
            $tasksFilterForm->load(Yii::$app->request->get());
        }

        $query = $tasksFilterForm->applyFilters($query);

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
            'tasksFilterForm' => $tasksFilterForm,
            'pagination' => $pagination,

        ]);
    }

    /**
     * Отображение одного задания.
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $task = Tasks::findOne($id);

        if (!$task) {
            throw new HttpException(404, 'Task not found');
        }

        return $this->render('view', [
            'task' => $task

        ]);
    }


}