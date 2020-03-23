<?php


namespace frontend\controllers;

use frontend\models\tasks\Tasks;
use frontend\models\tasks\TasksCompleteForm;
use frontend\models\tasks\TasksResponse;
use frontend\models\tasks\TasksResponseForm;
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
            ->orderBy(['tasks.creation_time' => SORT_DESC])
            ->where(['tasks.status' => Tasks::STATUS_NEW]);

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

        $user = Yii::$app->user->identity;

        $responses = $user->isAuthor($task) ? $task->tasksResponse : $task->getTasksResponseByUser($user);

        $availableActions = $task->getAvailableActions($user);

        $taskResponseForm = new TasksResponseForm();
        if ($taskResponseForm->load(Yii::$app->request->post()) && $taskResponseForm->validate()) {
            if ((new TaskService)->createResponse($task, $taskResponseForm, $user)) {
                return $this->redirect($task->link);
            }
        }

        $taskCompleteForm = new TasksCompleteForm();
        if ($taskCompleteForm->load(Yii::$app->request->post()) && $taskCompleteForm->validate()) {
            if ((new TaskService)->taskComplete($task, $taskCompleteForm, $user)) {
                return $this->redirect($task->link);
            }
        }

        return $this->render('view', [
            'task' => $task,
            'responses' => $responses,
            'user' => $user,
            'availableActions' => $availableActions,
            'taskResponseForm' => $taskResponseForm,
            'taskCompleteForm' => $taskCompleteForm
        ]);
    }

    public function actionCreate()
    {
        $user = Yii::$app->user->identity;

        $taskCreateForm = new TasksCreateForm();
        if ($taskCreateForm->load(Yii::$app->request->post()) && $taskCreateForm->validate()) {
            $taskCreateForm->files = UploadedFile::getInstances($taskCreateForm, 'files');
            if ($task = (new TaskService)->createTask($taskCreateForm, $user)) {
                return $this->redirect($task->link);
            }
        } else {
            $errors = $taskCreateForm->getErrors();
        }
        return $this->render('create', [
            'taskCreateForm' => $taskCreateForm,
            'errors' => $errors ?? []
        ]);
    }

    public function actionResponse($status, $id)
    {
        $response = TasksResponse::findOne($id);
        $user = Yii::$app->user->identity;

        if (!$response) {
            throw new HttpException(404, 'Отклик не найден');
        }

        if ($status == 'decline') {
            if ((new TaskService)->declineResponse($response,$user)) {
                return $this->redirect($response->task->link);
            }
        }

        if ($status == 'accept') {
            if ((new TaskService)->taskStart($response, $user)) {
                return $this->redirect($response->task->link);
            }
        }
        return $this->redirect($response->task->link);
    }

    public function actionCancel($id)
    {
        $task = Tasks::findOne($id);
        $user = Yii::$app->user->identity;

        if (!$task) {
            throw new HttpException(404, 'Задание не найдено');
        }

        if ((new TaskService)->taskCancel($task, $user)) {
            return $this->goHome();
        }
        return $this->redirect($task->link);

    }

    public function actionRefuse($id)
    {
        $task = Tasks::findOne($id);
        $user = Yii::$app->user->identity;

        if (!$task) {
            throw new HttpException(404, 'Задание не найдено');
        }

        $refuseTask = new TaskService();
        if ((new TaskService)->taskRefuse($task, $user)) {
            return $this->goHome();
        }
        return $this->redirect($task->link);

    }
}