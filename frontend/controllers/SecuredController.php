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
                        'actions' => ['index', 'view', 'logout', 'sort'],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                    [
                        'actions' => ['login', 'registration', 'landing'],
                        'allow' => true,
                        'roles' => ['?'],

                    ],
                    [
                        'actions' => ['index', 'view', 'logout', 'sort'],
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function ($rule, $action) {
                            return $action->controller->redirect('/landing');
                        }
                    ],
                    [
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