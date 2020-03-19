<?php


namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

abstract class SecuredController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'controllers' => ['tasks', 'users'],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                    [
                        'controllers' => ['site'],
                        'actions' => ['error', 'logout', 'index'],
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
                        'actions' => ['login', 'registration', 'landing'],
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