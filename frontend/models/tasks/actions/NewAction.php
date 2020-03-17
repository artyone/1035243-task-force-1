<?php


namespace frontend\models\tasks\actions;

use app\exception\ActionException;
use app\exception\RoleException;
use frontend\models\tasks\Tasks;
use frontend\models\users\Users;

class NewAction implements ActionInterface
{

    public static function getNameClass(): string
    {
        return NewAction::class;
    }

    public static function getActionName(): string
    {
        return 'new';
    }

    public static function verifyAction(Tasks $task, int $userId): bool
    {
        if (!Users::findOne($userId)->isCustomer()) {
            return false;
            //throw new RoleException('Ошибка. Роль пользователя не заказчик');
        }
        if ($task->status !== $task::STATUS_NEW) {
            return false;
            //throw new ActionException('Ошибка. Статус задачи не ' . $task::STATUS_NEW);
        }
        return true;
    }
}
