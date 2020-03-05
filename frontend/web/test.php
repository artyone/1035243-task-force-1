<?php

/*ini_set('error_reporting', E_ALL);
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
}*/

function ago($datetime)
{
    $interval = date_create('now')->diff( date_create($datetime));
/*    $suffix = ( $interval->invert ? ' ago' : '' );
    if ( $v = $interval->y >= 1 ) return pluralize( $interval->y, 'year' ) . $suffix;
    if ( $v = $interval->m >= 1 ) return pluralize( $interval->m, 'month' ) . $suffix;
    if ( $v = $interval->d >= 1 ) return pluralize( $interval->d, 'day' ) . $suffix;
    if ( $v = $interval->h >= 1 ) return pluralize( $interval->h, 'hour' ) . $suffix;
    if ( $v = $interval->i >= 1 ) return pluralize( $interval->i, 'minute' ) . $suffix;
    return pluralize( $interval->s, 'second' ) . $suffix;*/
    return $interval->y;
}

echo ago('2020-11-13 00:00:00');







