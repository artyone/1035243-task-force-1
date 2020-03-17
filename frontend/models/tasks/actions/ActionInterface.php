<?php


namespace frontend\models\tasks\actions;

use frontend\models\tasks\Tasks;

interface ActionInterface
{
    public static function getNameClass(): string;
    public static function getActionName(): string;
    public static function verifyAction(Tasks $task, int $userId): bool;
}
