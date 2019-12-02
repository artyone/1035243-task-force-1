<?php


namespace app\models\actions;

use app\models\Task;

class CompleteAction implements actionInterface
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
        if ($task->initiatorId === $task->getCustomer() && $task->getStatus() === $task::STATUS_EXECUTION) {
            return true;
        }
        return false;
    }
}
