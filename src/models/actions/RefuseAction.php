<?php


namespace app\models\actions;

use app\models\Task;

class RefuseAction implements ActionInterface
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
        if ($task->initiatorId === $task->getExecutor() && $task->getStatus() === $task::STATUS_EXECUTION) {
            return true;
        }
        return false;
    }
}
