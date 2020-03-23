<?php


namespace frontend\models\tasks\actions;

use frontend\models\tasks\Tasks;
use yii\web\IdentityInterface;

class AddResponseAction implements ActionInterface
{

    public static function getNameClass(): string
    {
        return AddResponseAction::class;
    }

    public static function getActionName(): string
    {
        return 'response';
    }

    public static function getActionDescription(): string
    {
        return 'Откликнуться';
    }

    public static function verifyAction(Tasks $task, IdentityInterface $user): bool
    {

        if (!$user->isExecutor() || $user->isAuthor($task)) {
            return false;
        }
        if ($task->getTasksResponseByUser($user) || $task->status !== Tasks::STATUS_NEW) {
            return false;
        }

        return true;
    }
}
