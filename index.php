<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'vendor/autoload.php';

use app\exception\ActionException;
use app\exception\RoleException;
use app\exception\StatusException;
use app\models\Task;

try {
    $task = new Task();
    $task->setInitiatorId(1);
    $task->setCustomerId(1);
    $task->setExecutorId(5);
    $task->getNewStatus('newTask');
    $task->start();
} catch (ActionException $exception){
    print $exception->getMessage() . "\n";
} catch (RoleException $exception){
    print $exception->getMessage() . "\n";
} catch (StatusException $exception){
    print $exception->getMessage() . "\n";
}



/*assert($task->getNewStatus('newTask') === Task::STATUS_NEW, 'При действии
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

assert($task->start() === null, 'При действии
"startTask" метод вернет null так как пользователь не имеет роли executor');

$task->setInitiatorId(5);

assert($task->start() === Task::STATUS_EXECUTION, 'При действии
"startTask" метод вернёт статус "execution"');

assert($task->refuse() === Task::STATUS_FAILED, 'При действии
"refuseTask" метод вернёт статус "fail"');

assert($task->cancel() === null, 'При действии
"cancelTask" метод вернёт null так как пользователь не совпадает с заказчиком и статус задачи не "в работе"');

$task->setInitiatorId(1);
$task->getNewStatus('newTask');

assert($task->cancel() === Task::STATUS_CANCELED, 'При действии
"cancelTask" метод вернёт статус "cancel"');
assert($task->complete() === null, 'При действии
"completeTask" метод вернёт null так как статус задачи "отменена"');

$task->getNewStatus('startTask');

assert($task->complete() === Task::STATUS_DONE, 'При действии
"completeTask" метод вернёт статус "done"');*/

print $task->getStatus();


