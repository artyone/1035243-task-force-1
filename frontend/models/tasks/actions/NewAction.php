<?php


namespace frontend\models\tasks\actions;

use frontend\models\tasks\Tasks;
use yii\web\IdentityInterface;

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

    public static function getActionDescription(): string
    {
        return 'Создать задание';
    }

    public static function verifyAction(?Tasks $task, IdentityInterface $user): bool
    {
        if (!$user->isCustomer()) {
            return false;
        }
        return true;
    }
}
