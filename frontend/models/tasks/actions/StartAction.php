<?php


namespace frontend\models\tasks\actions;

use app\exception\ActionException;
use app\exception\RoleException;
use frontend\models\tasks\Tasks;
use frontend\models\users\Users;

class StartAction implements ActionInterface
{

    public static function getNameClass(): string
    {
        return StartAction::class;
    }

    public static function getActionName(): string
    {
        return 'start';
    }

    public static function verifyAction(Tasks $task, int $userId): bool
    {
        if (!Users::findOne($userId)->isAuthor($task)) {
            return false;
            //throw new RoleException('Ошибка. Роль не соответсвует роли исполнителя');
        }
        if ($task->status !== $task::STATUS_NEW) {
            return false;
            //throw new ActionException('Ошибка. Статус задачи не ' . $task::STATUS_NEW);
        }
        return true;
    }
}
