<?php


namespace app\models\actions;

use app\models\Task;

class StartAction implements iActions
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
        if ($task->getRole() === 'executor' && $task->getStatus() === 'new') {
            return true;
        }
        return false;
    }
}
