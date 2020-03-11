<?php

namespace frontend\models;

use frontend\models\Users;
use yii\base\Model;
use frontend\models\UsersData;
use yii;


class RegistrationForm extends Model
{

    public $email;
    public $name;
    public $city;
    public $password;

    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
            'name' => 'Ваше имя',
            'city' => 'Город проживания',
            'password' => 'Пароль'
        ];
    }

    public function rules()
    {
        return [

            [['email', 'name', 'city', 'password'], 'safe'],
            [['email', 'name', 'city', 'password'], 'required'],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\frontend\models\Users', 'message' => 'Введенный адрес занят'],

            ['name', 'string', 'max' => 255],

            ['city', 'exist', 'targetClass' => '\frontend\models\Cities', 'targetAttribute' => 'id','message' => 'Выбран неверный город'],

            ['password', 'string', 'max' => 32],
            ['password', 'string', 'min' => 8],
        ];
    }

}