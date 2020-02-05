<?php


namespace app\models\actions;

use app\exception\ActionException;
use app\exception\RoleException;
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
        if ($userId !== $task->getExecutorId()) {
            throw new RoleException('Ошибка. Выбранный пользователь не исполнитель задачи');
        }
        if ($task->getStatus() !== $task::STATUS_EXECUTION) {
            throw new ActionException('Ошибка. Статус задачи не '. $task::STATUS_EXECUTION);
        }
        return true;
    }
}
