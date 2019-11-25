<?php


namespace app\models\actions;

use app\models\Task;

class CompleteAction implements iActions
{

    public static function getNameClass()
    {
        return CompleteAction::class;
    }

    public static function getActionName()
    {
        return 'completeTask';
    }

    public static function verifyAction(Task $task): bool
    {
        if ($task->user === $task->getCustomer() && $task->getStatus() === 'execution') {
            return true;
        }
        return false;
    }
}
