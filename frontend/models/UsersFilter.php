<?php


namespace frontend\models;

use yii\base\Model;

class UsersFilter extends Model
{

    public $categories;
    public $free;
    public $online;
    public $hasFeedback;
    public $inFavorites;
    public $search;

    public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'free' => 'Сейчас свободен',
            'online' => 'Сейчас онлайн',
            'hasFeedback' => 'Есть отзывы',
            'inFavorites' => 'В избранном',
            'search' => 'Поиск по имени'
        ];
    }

    public function rules()
    {
        return [
            [['categories', 'free','online', 'hasFeedback', 'inFavorites', 'search'], 'safe'],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function getOnlineTime()
    {
        $date = new \DateTime();
        $date->sub(\DateInterval::createFromDateString('30 minutes'));
        $result = $date->format('Y-m-d H:i:s');
        return $result;
    }
}