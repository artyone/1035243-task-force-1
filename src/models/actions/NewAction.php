<?php


namespace app\models\actions;

use app\models\Task;
use app\models\User;

class NewAction implements ActionInterface
{

    public static function getNameClass(): string
    {
        return NewAction::class;
    }

    public static function getActionName(): string
    {
        return 'newTask';
    }

    public static function verifyAction(Task $task, int $userId): bool
    {
        if (User::isCustomer($userId) === true && $task->getStatus() === $task::STATUS_NEW) {
            return true;
        }
        return false;
    }
}
