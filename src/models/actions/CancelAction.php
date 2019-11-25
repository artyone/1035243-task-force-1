<?php


namespace app\models\actions;

use app\models\Task;

class CancelAction implements iActions
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
        if ($task->user === $task->getCustomer() && $task->getStatus() === 'new') {
            return true;
        }
        return false;
    }
}
