<?php


namespace app\models\actions;

use app\models\Task;

interface ActionInterface
{
    public static function getNameClass(): string;
    public static function getActionName(): string;
    public static function verifyAction(Task $task, int $userId): bool;
}
