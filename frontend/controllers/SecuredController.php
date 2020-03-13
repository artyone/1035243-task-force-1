<?php


namespace frontend\controllers;

use frontend\models\users\Users;
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
                        'actions' => ['index', 'view', 'logout', 'sort'],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Users::findOne(Yii::$app->user->getIdentity()->id)->isCustomer();
                        }

                    ],
                    [
                        'actions' => ['login', 'registration', 'landing'],
                        'allow' => true,
                        'roles' => ['?'],

                    ],
                    [
                        'actions' => ['index', 'view', 'logout', 'create', 'sort'],
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function ($rule, $action) {
                            return $action->controller->redirect('/landing');
                        }
                    ],
                    [
                        'actions' => ['login', 'registration', 'landing', 'create'],
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