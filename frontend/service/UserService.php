<?php


namespace frontend\service;

use frontend\models\RegistrationForm;
use frontend\models\users\Users;
use frontend\models\users\UsersData;
use yii\base\Model;
use yii;

/**
 * User service
 */
class UserService extends Model
{
    /**
     * Регистрация
     * @param RegistrationForm $model модель формы регистрации
     * @return bool true - регистрация прошла успешно, false - регистрация не удалась
     * @throws yii\db\Exception
     */
    public static function registration(RegistrationForm $model): bool
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

/*    public static function login($user) {
        return Yii::$app->user->login($user);
    }*/

    public function logout() {
        //@TODO реализовать в следующем задании
    }

}