<?php


namespace frontend\models\tasks\actions;

use app\exception\RoleException;
use app\exception\ActionException;
use frontend\models\tasks\Tasks;

class CancelAction implements ActionInterface
{

    public static function getNameClass(): string
    {
        return CancelAction::class;
    }

    public static function getActionName(): string
    {
        return 'cancel';
    }

    public static function verifyAction(Tasks $task, int $userId): bool
    {
        if ($userId !== $task->customer->id) {
            //throw new RoleException('Ошибка. Выбранный пользователь не иницицатор задачи');
            return false;
        }
        if ($task->status !== $task::STATUS_NEW) {
            return false;
            //throw new ActionException('Ошибка. Статус задачи не ' . $task::STATUS_NEW);
        }
        return true;
    }
}
