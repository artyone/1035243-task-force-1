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

        $users = $query->orderBy(['creation_time' => SORT_DESC])
            ->all();

        $users2 = [];
        foreach ($users as $user) {
            if ($user->userCategories) {
                $users2[] = $user;
            }
        }

        return $this->render('index', [
            'users' => $users2
        ]);
    }

}