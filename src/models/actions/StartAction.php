<?php


namespace app\models\actions;

use app\models\Task;
use app\models\User;

class StartAction implements ActionInterface
{

    public static function getNameClass()
    {
        return StartAction::class;
    }

    public static function getActionName()
    {
        return 'startTask';
    }

    public static function verifyAction(Task $task): bool
    {
        if (User::getRole($task->initiatorId) === 'executor' && $task->getStatus() === $task::STATUS_NEW) {
            return true;
        }
        return false;
    }
}
