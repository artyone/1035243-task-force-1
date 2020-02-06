<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'vendor\autoload.php';

use app\models\ConvertCsv;

foreach (glob('data/*.csv') as $pathFile) {
    $file = new ConvertCsv($pathFile);
    $file->import();
}




