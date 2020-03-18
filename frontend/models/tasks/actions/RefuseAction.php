<?php


namespace frontend\models\tasks\actions;

use frontend\models\tasks\Tasks;
use yii\web\IdentityInterface;

class RefuseAction implements ActionInterface
{

    public static function getNameClass(): string
    {
        return RefuseAction::class;
    }

    public static function getActionName(): string
    {
        return 'refuse';
    }

    public static function getActionDescription(): string
    {
        return 'Отказаться';
    }

    public static function verifyAction(Tasks $task, IdentityInterface $user): bool
    {
        if (!$user->isContractor($task)) {
            return false;
            //throw new RoleException('Ошибка. Выбранный пользователь не исполнитель задачи');
        }
        if ($task->status !== $task::STATUS_EXECUTION) {
            return false;
            //throw new ActionException('Ошибка. Статус задачи не '. $task::STATUS_EXECUTION);
        }
        return true;
    }
}
