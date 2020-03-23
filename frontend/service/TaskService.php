<?php


namespace frontend\service;

use frontend\models\Files;
use frontend\models\tasks\actions\AddResponseAction;
use frontend\models\tasks\actions\CancelAction;
use frontend\models\tasks\actions\CompleteAction;
use frontend\models\tasks\actions\NewAction;
use frontend\models\tasks\actions\RefuseAction;
use frontend\models\tasks\actions\StartAction;
use frontend\models\tasks\TasksCompleteForm;
use frontend\models\tasks\TasksCreateForm;
use frontend\models\tasks\Tasks;
use frontend\models\tasks\TasksFeedback;
use frontend\models\tasks\TasksFile;
use frontend\models\tasks\TasksResponse;
use frontend\models\tasks\TasksResponseForm;
use yii\base\Model;
use yii;
use yii\web\IdentityInterface;

/**
 * Task service
 */
class TaskService extends Model
{

    public function createTask(TasksCreateForm $model, IdentityInterface $user): ?Tasks
    {
        if(!NewAction::verifyAction(null, $user)) {
            return null;
        }

        $transaction = Yii::$app->db->beginTransaction();

        $task = new Tasks();
        $task->name = $model->name;
        $task->description = $model->description;
        $task->category_id = $model->categoryId;
        $task->price = $model->price;
        $task->deadline_time = $model->deadlineTime;
        $task->customer_id = $user->id;
        $task->status = Tasks::STATUS_NEW;
        $task->city_id = $user->userData->city_id;

        if (!$task->save()) {
            $transaction->rollBack();
            return null;
        }
        if (!$this->uploadFiles($model->files, $task->id)) {
            $transaction->rollBack();
            return null;
        }
        $transaction->commit();

        return $task;
    }

    private function uploadFiles(array $files, int $taskId): bool
    {
        foreach ($files as $file) {
            $filePath = 'taskfiles/' . $taskId . '_' . $file->name;
            if (!$file->saveAs($filePath)) {
                return false;
            }
            $fileInDb = new Files();
            $fileInDb->link = '/' . $filePath;
            if (!$fileInDb->save()) {
                return false;
            }
            $taskFile = new TasksFile();
            $taskFile->task_id = $taskId;
            $taskFile->file_id = $fileInDb->id;
            if (!$taskFile->save()) {
                return false;
            }
        }
        return true;
    }

    public function createResponse(Tasks $task, TasksResponseForm $model, IdentityInterface $user): bool
    {
        if (!AddResponseAction::verifyAction($task, $user)){
            return false;
        }
        $taskResponse = new TasksResponse();
        $taskResponse->task_id = $task->id;
        $taskResponse->executor_id = $user->id;
        $taskResponse->price = $model->price;
        $taskResponse->description = $model->descriptionResponse;
        if (!$taskResponse->save()) {
            return false;
        }
        return true;
    }

    public function declineResponse(TasksResponse $response, IdentityInterface $user): bool
    {
        if (!$user->isAuthor($response->task)) {
            return false;
        }
        $response->status = TasksResponse::STATUS_DECLINE;
        if (!$response->save()) {
            return false;
        }
        return true;
    }

    public function taskStart(TasksResponse $response, IdentityInterface $user): bool
    {
        $task = $response->task;

        if (!StartAction::verifyAction($task, $user)) {
            return false;
        }

        $task->start();
        $task->executor_id = $response->executor_id;
        $task->price = $response->price;
        if (!$task->save()) {
            return false;
        }
        return true;
    }

    public function taskCancel(Tasks $task, IdentityInterface $user): bool
    {
        if (!CancelAction::verifyAction($task, $user)) {
            return false;
        }
        $task->cancel();
        if (!$task->save()) {
            return false;
        }
        return true;
    }

    public function taskRefuse(Tasks $task, IdentityInterface $user): bool
    {

        if (!RefuseAction::verifyAction($task, $user)) {
            return false;
        }
        $task->refuse();
        if (!$task->save()) {
            return false;
        }

        $user->userData->updateTaskCount();

        return true;
    }

    public function taskComplete(Tasks $task, TasksCompleteForm $model, IdentityInterface $user)
    {

        if (!CompleteAction::verifyAction($task, $user)) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        switch ($model->isComplete) {
            case 'yes':
                $task->complete();
                break;
            case 'difficult':
                $task->refuse();
                break;
        }
        if (!$task->save()) {
            $transaction->rollBack();
            return false;
        }
        $newFeedback = new TasksFeedback();
        $newFeedback->customer_id = $task->customer_id;
        $newFeedback->executor_id = $task->executor_id;
        $newFeedback->task_id = $task->id;
        $newFeedback->description = $model->descriptionComplete;
        $newFeedback->rating = $model->rating;
        if (!$newFeedback->save()) {
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();

        $task->executor->userData->updateTaskCount();
        $task->executor->userData->updateRating();

        return true;


    }
}