<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'vendor\autoload.php';

use app\models\Task;

$task = new Task(1);
$task->setCustomer(1);
$task->setExecutor(5);

assert($task->getNewStatus('newTask') === Task::STATUS_NEW, 'При действии
"newTask" метод вернёт статус "new"');
assert($task->getNewStatus('startTask') === Task::STATUS_EXECUTION, 'При действии
"startTask" метод вернёт статус "execution"');
assert($task->getNewStatus('cancelTask') === Task::STATUS_CANCELED, 'При действии
"cancelTask" метод вернёт статус "cancel"');
assert($task->getNewStatus('refuseTask') === Task::STATUS_FAILED, 'При действии
"refuseTask" метод вернёт статус "fail"');
assert($task->getNewStatus('completeTask') === Task::STATUS_DONE, 'При действии
"completeTask" метод вернёт статус "done"');

$task->getNewStatus('newTask');

assert($task->setNewStatus() === Task::STATUS_NEW, 'При действии
"newTask" метод вернёт статус "new"');
assert($task->setStartStatus() === null, 'При действии
"startTask" метод вернет null так как пользователь не имеет роли executor');

$task->setUser(5);

assert($task->setStartStatus() === Task::STATUS_EXECUTION, 'При действии
"startTask" метод вернёт статус "execution"');

assert($task->setRefuseStatus() === Task::STATUS_FAILED, 'При действии
"refuseTask" метод вернёт статус "fail"');

assert($task->setCancelStatus() === null, 'При действии
"cancelTask" метод вернёт null так как пользователь не совпадает с заказчиком и статус задачи не "в работе"');

$task->setUser(1);
$task->getNewStatus('newTask');

assert($task->setCancelStatus() === Task::STATUS_CANCELED, 'При действии
"cancelTask" метод вернёт статус "cancel"');
assert($task->setCompleteStatus() === null, 'При действии
"completeTask" метод вернёт null так как статус задачи "отменена"');

$task->getNewStatus('startTask');

assert($task->setCompleteStatus() === Task::STATUS_DONE, 'При действии
"completeTask" метод вернёт статус "done"');

print $task->getStatus();
