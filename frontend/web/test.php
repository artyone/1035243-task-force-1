<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . '/../../vendor/autoload.php';

use app\models\ConvertCsv;

foreach (glob('data/*.csv') as $pathFile) {
    $file = new ConvertCsv($pathFile);
    $file->convert();
}

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









