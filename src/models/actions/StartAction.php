<?php


namespace app\models\actions;

use app\exception\ActionException;
use app\exception\RoleException;
use app\models\Task;
use app\models\User;

class StartAction implements ActionInterface
{

    public static function getNameClass(): string
    {
        return StartAction::class;
    }

    public static function getActionName(): string
    {
        return 'startTask';
    }

    public static function verifyAction(Task $task, int $userId): bool
    {
        if (!User::isExecutor($userId) ) {
            throw new RoleException('Ошибка. Роль не соответсвует роли исполнителя');
        }
        if (!$task->getStatus() !== $task::STATUS_NEW) {
            throw new ActionException('Ошибка. Статус задачи не ' . $task::STATUS_NEW);
        }
        return true;
    }
}
