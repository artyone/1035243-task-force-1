<?php


namespace frontend\controllers;

use frontend\models\tasks\Tasks;
use frontend\models\tasks\TasksResponse;
use frontend\models\tasks\TasksResponseForm;
use yii\data\Pagination;
use frontend\models\tasks\TasksFilterForm;
use yii;
use yii\web\HttpException;
use frontend\models\tasks\TasksCreateForm;
use yii\web\UploadedFile;
use frontend\service\TaskService;
use yii\helpers\Url;


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

        $user = Yii::$app->user->identity;

        $responses = $user->isAuthor($task) ? $task->tasksResponse : $task->getTasksResponseByUser($user->id);

        $availableActions = $task->getAvailableActions($user->id);

        $taskResponseForm = new TasksResponseForm();
        if ($taskResponseForm->load(Yii::$app->request->post()) && $taskResponseForm->validate()) {
            $newResponse = new TaskService();
            if ($newResponse->createResponse($task, $taskResponseForm, $user)) {
                return $this->redirect(URL::to($task->getLink()));
            }
        }

        return $this->render('view', [
            'task' => $task,
            'responses' => $responses,
            'user' => $user,
            'availableActions' => $availableActions,
            'taskResponseForm' => $taskResponseForm
        ]);
    }

    public function actionCreate()
    {
        $taskCreateForm = new TasksCreateForm();
        if (Yii::$app->request->getIsPost()) {
            $taskCreateForm->load(Yii::$app->request->post());
            $taskCreateForm->files = UploadedFile::getInstances($taskCreateForm, 'files');
            if ($taskCreateForm->validate()) {
                $newTask = new TaskService();
                if ($link = $newTask->createTask($taskCreateForm)) {
                    return $this->redirect(URL::to($link));
                }
            } else {
                $errors = $taskCreateForm->getErrors();
            }
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
            $responseDecline = new TaskService();
            if ($responseDecline->declineResponse($response, $user)) {
                return $this->redirect($response->task->link);
            }
        }

        if ($status == 'accept') {
            $taskStart = new TaskService();
            if ($taskStart->taskStart($response, $user)) {
                return $this->redirect($response->task->link);
            }
        }
        return $this->redirect($response->task->link);
    }
}