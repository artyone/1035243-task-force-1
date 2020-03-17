<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'frontend\models\users\Users',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '//' => '/',
                'tasks' => 'tasks/index',
                'task/view/<id:\d+>' => 'tasks/view',
                'task/create' => 'tasks/create',
                'task/response/<status:\w+>/<id:\d+>' => 'tasks/response',
                'users' => 'users/index',
                'user/view/<id:\d+>' => 'users/view',
                'users/sort/<sort:\w+>' => 'users/sort',
                'registration' => 'site/registration',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'landing' => 'site/landing',

            ]
        ]
    ],
    'params' => $params,
];
