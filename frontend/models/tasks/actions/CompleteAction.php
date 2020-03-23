<?php


namespace frontend\models\tasks\actions;

use frontend\models\tasks\Tasks;
use yii\web\IdentityInterface;

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

    public static function getActionDescription(): string
    {
        return 'Завершить';
    }

    public static function verifyAction(Tasks $task, IdentityInterface $user): bool
    {
        if (!$user->isAuthor($task)) {
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
