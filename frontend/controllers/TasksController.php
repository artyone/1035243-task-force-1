<?php


namespace frontend\controllers;

use frontend\models\tasks\Tasks;
use yii\data\Pagination;
use frontend\models\tasks\TasksFilterForm;
use yii;
use yii\web\HttpException;
use frontend\models\tasks\TasksCreateForm;
use yii\web\UploadedFile;
use frontend\service\TaskService;


/**
 * Tasks controller
 */
class TasksController extends SecuredController
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
        $tasksFilterForm->load(Yii::$app->request->get());


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
     * @throws HttpException
     */
    public function actionView($id)
    {
        $task = Tasks::findOne($id);

        if (!$task) {
            throw new HttpException(404, 'Задание не найдено');
        }

        return $this->render('view', [
            'task' => $task
        ]);
    }

    public function actionCreate()
    {
        $taskCreateForm = new TasksCreateForm();
        if ($taskCreateForm->load(Yii::$app->request->post()) && $taskCreateForm->validate()) {
            $taskCreateForm->files = UploadedFile::getInstances($taskCreateForm, 'files');
            $newTask = new TaskService();
            if ($task = $newTask->create($taskCreateForm)) {
                return $this->redirect($task->taskLink);
            } else {
                $errors = $taskCreateForm->getErrors();
            }
        }
        return $this->render('create', [
            'taskCreateForm' => $taskCreateForm,
            'errors' => $errors?? []
        ]);

    }
}