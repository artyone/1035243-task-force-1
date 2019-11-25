<?php


namespace app\models\actions;

use app\models\Task;

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
        if ($task->getRole() === 'customer' && $task->getStatus() === 'new') {
            return true;
        }
        return false;
    }
}
