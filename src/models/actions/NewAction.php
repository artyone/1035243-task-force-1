<?php


namespace app\models\actions;

use app\models\Task;
use app\models\User;

class NewAction implements iActions
{

    public static function getNameClass()
    {
        return NewAction::class;
    }

    public static function getActionName()
    {
        return 'newTask';
    }

    public static function verifyAction(Task $task): bool
    {
        if (User::getRole($task->initiatorId) === 'customer' && $task->getStatus() === $task::STATUS_NEW) {
            return true;
        }
        return false;
    }
}
