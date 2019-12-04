<?php


namespace app\models\actions;

use app\models\Task;

class CancelAction implements ActionInterface
{

    public static function getNameClass(): string
    {
        return CancelAction::class;
    }

    public static function getActionName(): string
    {
        return 'cancelTask';
    }

    public static function verifyAction(Task $task, int $userId): bool
    {
        if ($userId === $task->getCustomerId() && $task->getStatus() === $task::STATUS_NEW) {
            return true;
        }
        return false;
    }
}
