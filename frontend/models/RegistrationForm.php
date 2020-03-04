<?php

namespace frontend\models;

use frontend\models\Users;
use yii\base\Model;

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
            ['email', 'unique', 'targetClass' => '\frontend\models\Users', 'message' => 'This email address has already been taken.'],

            ['city', 'exist', 'targetClass' => '\frontend\models\Cities', 'targetAttribute' => 'name','message' => 'This city not exists'],

            ['password', 'string', 'min' => 8],
        ];
    }

}