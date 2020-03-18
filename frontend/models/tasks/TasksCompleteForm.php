<?php

namespace frontend\models\tasks;

use yii\base\Model;

/**
 * Task complete form
 */
class TasksCompleteForm extends Model
{
    /**
     * {@inheritdoc}
     */
public $isComplete;
public $descriptionComplete;
public $rating;


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'isComplete' => 'Задание выполнено?',
            'descriptionComplete' => 'Комментарий',
            'rating' => 'Оценка'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'price', 'rating'], 'safe'],
            [['isComplete'], 'required', 'message' => 'Необходимо указать выполнено ли задание'],
            ['descriptionComplete', 'string', 'length' => [0, 200]],
            ['rating', 'integer', 'min' => 1, 'max' => 5],
            ['rating', 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function formName()
    {
        return '';
    }


}