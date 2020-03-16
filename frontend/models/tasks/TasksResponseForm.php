<?php

namespace frontend\models\tasks;

use yii\base\Model;
use yii\web\UploadedFile;
use frontend\models\Files;
use frontend\models\tasks\TasksFile;

/**
 * Task creation form
 */
class TasksResponseForm extends Model
{
    /**
     * {@inheritdoc}
     */
public $price;
public $description;


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'price' => 'Ваша цена',
            'description' => 'Комментарий'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'price'], 'safe'],
            ['description', 'string', 'length' => [0, 200]],
            ['price', 'integer', 'min' => '1'],
            ['price', 'default', 'value' => null],
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