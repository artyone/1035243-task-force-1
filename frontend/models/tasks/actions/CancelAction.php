<?php


namespace frontend\models\tasks\actions;

use frontend\models\tasks\Tasks;
use yii\web\IdentityInterface;

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

    public static function getActionDescription(): string
    {
        return 'Отменить';
    }

    public static function verifyAction(Tasks $task, IdentityInterface $user): bool
    {
        if (!$user->isAuthor($task)) {
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
