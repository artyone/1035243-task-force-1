<?php


namespace frontend\service;

use frontend\models\Files;
use frontend\models\tasks\TasksCreateForm;
use frontend\models\tasks\Tasks;
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

    public function createTask(TasksCreateForm $model): ?Tasks
    {
        $transaction = Yii::$app->db->beginTransaction();

        $task = new Tasks();
        $task->name = $model->name;
        $task->description = $model->description;
        $task->category_id = $model->categoryId;
        $task->price = $model->price;
        $task->deadline_time = $model->deadlineTime;
        $task->customer_id = Yii::$app->user->identity->id;
        $task->status = Tasks::STATUS_NEW;

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

        if (!$user->canResponse($task)) {
            return false;
        }
        $taskResponse = new TasksResponse();
        $taskResponse->task_id = $task->id;
        $taskResponse->executor_id = $user->id;
        $taskResponse->price = $model->price;
        $taskResponse->description = $model->description;
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
        if(!$task->start($user->id)) {
            return false;
        }

        $task->executor_id = $response->executor_id;
        $task->price = $response->price;
        if (!$task->save()) {
            return false;
        }
        return true;
    }
}