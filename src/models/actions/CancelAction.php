<?php


namespace app\models\actions;

use app\exception\RoleException;
use app\exception\ActionException;
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
        if ($userId !== $task->getCustomerId()) {
            throw new RoleException('Ошибка. Выбранный пользователь не иницицатор задачи');
        }
        if ($task->getStatus() !== $task::STATUS_NEW) {
            throw new ActionException('Ошибка. Статус задачи не ' . $task::STATUS_NEW);
        }
        return true;
    }
}
