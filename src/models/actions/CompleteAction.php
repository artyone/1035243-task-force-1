<?php


namespace app\models\actions;

use app\exception\RoleException;
use app\exception\ActionException;
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
        if ($userId !== $task->getCustomerId()) {
            throw new RoleException('Ошибка. Выбранный пользователь не инициатор задачи');
        }
        if ($task->getStatus() !== $task::STATUS_EXECUTION) {
            throw new ActionException('Ошибка. Статус задачи не ' . $task::STATUS_EXECUTION);
        }
        return true;
    }
}
