<?php


namespace frontend\models\tasks\actions;

use app\exception\ActionException;
use app\exception\RoleException;
use frontend\models\tasks\Tasks;

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

    public static function verifyAction(Tasks $task, int $userId): bool
    {
        if ($userId !== $task->executor->id) {
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
