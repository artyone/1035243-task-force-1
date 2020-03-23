<?php


namespace frontend\models\tasks\actions;

use frontend\models\tasks\Tasks;
use yii\web\IdentityInterface;

interface ActionInterface
{
    public static function getNameClass(): string;
    public static function getActionName(): string;
    public static function getActionDescription(): string;
    public static function verifyAction(Tasks $task, IdentityInterface $user): bool;
}
