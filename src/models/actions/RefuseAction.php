<?php


namespace app\models\actions;

use app\models\Task;

class RefuseAction implements iActions
{

    public static function getNameClass()
    {
        return RefuseAction::class;
    }

    public static function getActionName()
    {
        return 'refuseTask';
    }

    public static function verifyAction(Task $task): bool
    {
        if ($task->user === $task->getExecutor() && $task->getStatus() === 'execution') {
            return true;
        }
        return false;
    }
}
