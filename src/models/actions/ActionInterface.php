<?php


namespace app\models\actions;

use app\models\Task;

interface ActionInterface
{
    public static function getNameClass();
    public static function getActionName();
    public static function verifyAction(Task $task, int $userId) :bool;
}
