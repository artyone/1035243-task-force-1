<?php


namespace app\models\actions;

use app\models\Task;

class CancelAction implements actionInterface
{

    public static function getNameClass()
    {
        return CancelAction::class;
    }

    public static function getActionName()
    {
        return 'cancelTask';
    }

    public static function verifyAction(Task $task): bool
    {
        if ($task->initiatorId === $task->getCustomer() && $task->getStatus() === $task::STATUS_NEW) {
            return true;
        }
        return false;
    }
}
