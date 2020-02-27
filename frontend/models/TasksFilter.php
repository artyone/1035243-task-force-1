<?php


namespace frontend\models;

use yii\base\Model;

class TasksFilter extends Model
{

    public $categories;
    public $noResponse;
    public $remoteWork;
    public $period;
    public $search;

    public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'noResponse' => 'Без откликов',
            'remoteWork' => 'Удаленная работа',
            'period' => 'Период',
            'search' => 'Поиск',
        ];
    }

    public function rules()
    {
        return [
            [['categories', 'noResponse', 'remoteWork', 'period', 'search'], 'safe'],
        ];
    }
}