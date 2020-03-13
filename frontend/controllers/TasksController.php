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
        if (Yii::$app->request->isGet) {
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
     * @throws HttpException
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

    public function actionCreate()
    {

        $taskCreateForm = new TasksCreateForm();
        if (Yii::$app->request->getIsPost()) {
            $taskCreateForm->load(Yii::$app->request->post());
            $taskCreateForm->files = UploadedFile::getInstances($taskCreateForm, 'files');
/*            if ($taskCreateForm->upload()) {
                // file is uploaded successfully
                return $this->goHome();
            }*/


            if ($taskCreateForm->validate()) {
                if(TaskService::create($taskCreateForm)) {
                    return $this->goHome();
                }
            }
        }
        return $this->render('create', [
            'taskCreateForm' => $taskCreateForm
        ]);

    }
}