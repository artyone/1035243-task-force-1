<?php


namespace frontend\controllers;

use frontend\models\Users;
use yii\db\Query;
use yii\web\Controller;


class UsersController extends Controller
{

    public function actionIndex()
    {

        $query = Users::find();

        $users = $query
            ->orderBy(['creation_time' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'users' => $users
        ]);
    }

}