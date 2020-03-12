<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'language' => 'ru-RU',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '//' => '/',
                'tasks' => 'tasks/index',
                'users' => 'users/index',
                'registration' => 'registration/index',
                'landing' => 'landing/index',
                'task/view/<id:\d+>' => 'tasks/view',
                'user/view/<id:\d+>' => 'users/view',
                'users/sort/<sort:\w+>' => 'users/sort'
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
