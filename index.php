<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'src/main/Task.php';

use app\main\Task;

$newTask = new Task();

assert($newTask->getNewStatus(Task::ACTION_NEW) === Task::STATUS_NEW, 'статус "New" не присвоен');
assert($newTask->getNewStatus(Task::ACTION_START) === Task::STATUS_EXECUTION, 'статус "Execution" не присвоен');
assert($newTask->getNewStatus(Task::ACTION_CANCEL) === Task::STATUS_CANCELED, 'статус "Cancel" не присвоен');
assert($newTask->getNewStatus(Task::ACTION_REFUSE) === Task::STATUS_FAILED, 'статус "Failed" не присвоен');
assert($newTask->getNewStatus(Task::ACTION_COMPLETE) === Task::STATUS_DONE, 'статус "Done" не присвоен');

