<?php


namespace frontend\models\tasks\actions;

use app\exception\RoleException;
use app\exception\ActionException;
use frontend\models\tasks\Tasks;

class CompleteAction implements ActionInterface
{

    public static function getNameClass(): string
    {
        return CompleteAction::class;
    }

    public static function getActionName(): string
    {
        return 'complete';
    }

    public static function verifyAction(Tasks $task, int $userId): bool
    {
        if ($userId !== $task->customer->id) {
            return false;
            //throw new RoleException('Ошибка. Выбранный пользователь не инициатор задачи');
        }
        if ($task->status !== $task::STATUS_EXECUTION) {
            return false;
            //throw new ActionException('Ошибка. Статус задачи не ' . $task::STATUS_EXECUTION);
        }
        return true;
    }
}
