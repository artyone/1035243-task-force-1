<?php


namespace frontend\service;

use frontend\models\Users;
use frontend\models\UsersData;
use yii\base\Model;
use yii;

class UserService extends Model
{

    public function registration($model)
    {

        $transaction = Yii::$app->db->beginTransaction();

        $user = new Users();
        $user->name = $model->name;
        $user->email = $model->email;
        $user->setPassword($model->password);
        if (!$user->save()) {
            $transaction->rollBack();
            return false;
        }
        $userData = new UsersData();
        $userData->user_id = $user->id;
        $userData->city_id = $model->city;
        if (!$userData->save()) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();
        return true;
    }

    public function authentication($model) {
        //@TODO реализовать в следующем задании
    }

    public function logout() {
        //@TODO реализовать в следующем задании
    }

}