<?php


namespace app\models\actions;

use app\models\Task;

class CompleteAction implements ActionInterface
{

    public static function getNameClass(): string
    {
        return CompleteAction::class;
    }

    public static function getActionName(): string
    {
        return 'completeTask';
    }

    public static function verifyAction(Task $task, int $userId): bool
    {
        if ($userId === $task->getCustomerId() && $task->getStatus() === $task::STATUS_EXECUTION) {
            return true;
        }
        return false;
    }
}
