<?php


namespace frontend\service;

use frontend\models\tasks\TasksCreateForm;
use frontend\models\tasks\Tasks;
use yii\base\Model;
use yii;

/**
 * Task service
 */
class TaskService extends Model
{

    public static function create(TasksCreateForm $model): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        $task = new Tasks();
        $task->name = $model->name;
        $task->description = $model->description;
        $task->category_id = $model->categoryId;
        $task->price = $model->price;
        $task->deadline_time = $model->deadlineTime;

        if (!$task->save()) {
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
        return true;
    }

}