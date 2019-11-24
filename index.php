<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'vendor\autoload.php';

use app\models\Task;

$task = new Task();

assert($task->getNewStatus(Task::ACTION_NEW) === Task::STATUS_NEW, 'При действии 
"newTask" метод вернёт статус "new"');
assert($task->getNewStatus(Task::ACTION_START) === Task::STATUS_EXECUTION, 'При действии 
"startTask" метод вернёт статус "execution"');
assert($task->getNewStatus(Task::ACTION_CANCEL) === Task::STATUS_CANCELED, 'При действии 
"cancelTask" метод вернёт статус "cancel"');
assert($task->getNewStatus(Task::ACTION_REFUSE) === Task::STATUS_FAILED, 'При действии 
"refuseTask" метод вернёт статус "fail"');
assert($task->getNewStatus(Task::ACTION_COMPLETE) === Task::STATUS_DONE, 'При действии 
"completeTask" метод вернёт статус "done"');
