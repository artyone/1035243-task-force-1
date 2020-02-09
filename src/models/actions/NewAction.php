<?php


namespace app\models\actions;

use app\exception\ActionException;
use app\exception\RoleException;
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
        if (!User::isCustomer($userId)) {
            throw new RoleException('Ошибка. Роль пользователя не заказчик');
        }
        if ($task->getStatus() !== $task::STATUS_NEW) {
            throw new ActionException('Ошибка. Статус задачи не ' . $task::STATUS_NEW);
        }
        return true;
    }
}
