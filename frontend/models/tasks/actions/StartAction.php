<?php


namespace frontend\models\tasks\actions;

use frontend\models\tasks\Tasks;
use yii\web\IdentityInterface;

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

    public static function getActionDescription(): string
    {
        return 'Подтвердить';
    }

    public static function verifyAction(Tasks $task, IdentityInterface $user): bool
    {
        if (!$user->isAuthor($task)) {
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
