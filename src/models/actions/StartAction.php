<?php


namespace app\models\actions;

use app\models\Task;
use app\models\User;

class StartAction implements ActionInterface
{

    public static function getNameClass(): string
    {
        return StartAction::class;
    }

    public static function getActionName(): string
    {
        return 'startTask';
    }

    public static function verifyAction(Task $task, int $userId): bool
    {
        if (User::isExecutor($userId) === true && $task->getStatus() === $task::STATUS_NEW) {
            return true;
        }
        return false;
    }
}
