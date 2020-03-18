<?php

namespace frontend\models\tasks;

use yii\base\Model;
use yii\web\UploadedFile;
use frontend\models\Files;
use frontend\models\tasks\TasksFile;

/**
 * Task creation form
 */
class TasksCreateForm extends Model
{
    /**
     * {@inheritdoc}
     */
    public $name;
    public $description;
    public $categoryId;
    public $files;
    public $location;
    public $price;
    public $deadlineTime;


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'categoryId' => 'Категория',
            'files' => 'Файлы',
            'location' => 'Локация',
            'price' => 'Бюджет',
            'deadlineTime' => 'Срок исполнения',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'categoryId', 'files', 'location', 'price', 'deadlineTime'], 'safe'],
            [['name', 'description', 'categoryId'], 'required'],
            ['name', 'string', 'length' => [10, 30]],
            ['description', 'string', 'length' => [30, 200]],
            [
                'categoryId',
                'exist',
                'targetClass' => '\frontend\models\Categories',
                'targetAttribute' => 'id',
                'message' => 'Выбрана неверная категория'
            ],
            //@TODO доработь location после реализации локаций
            ['files', 'file', 'maxFiles' => 4],
            ['price', 'integer', 'min' => '1', 'max' => '99999'],
            ['price', 'default', 'value' => null],
            ['deadlineTime', 'date', 'format' => 'php:Y-m-d', 'min' => date('Y-m-d')],
            ['deadlineTime', 'default', 'value' => null]
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