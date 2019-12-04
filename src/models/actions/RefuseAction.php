<?php


namespace app\models\actions;

use app\models\Task;

class RefuseAction implements ActionInterface
{

    public static function getNameClass(): string
    {
        return RefuseAction::class;
    }

    public static function getActionName(): string
    {
        return 'refuseTask';
    }

    public static function verifyAction(Task $task, int $userId): bool
    {
        if ($userId === $task->getExecutorId() && $task->getStatus() === $task::STATUS_EXECUTION) {
            return true;
        }
        return false;
    }
}
