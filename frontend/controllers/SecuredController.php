<?php


namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

abstract class SecuredController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'controllers' => ['tasks'],
                        'actions' => ['create'],
                        'allow' => false,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->isExecutor();
                        }
                    ],
                    [
                        'controllers' => ['tasks', 'users'],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                    [
                        'controllers' => ['site'],
                        'actions' => ['error', 'logout', 'index', 'landing'],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                    [
                        'controllers' => ['site'],
                        'actions' => ['login', 'registration', 'landing', 'error'],
                        'allow' => true,
                        'roles' => ['?'],

                    ],
                    [
                        'controllers' => ['tasks', 'users'],
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function ($rule, $action) {
                            return $action->controller->redirect('/landing');
                        }
                    ],
                    [
                        'controllers' => ['site'],
                        'actions' => ['login', 'registration'],
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function ($rule, $action) {
                            return $action->controller->redirect('/');
                        }
                    ]
                ]
            ]
        ];
    }
}