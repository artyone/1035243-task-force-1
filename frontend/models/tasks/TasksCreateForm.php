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
            ['name', 'string', 'max' => 50],
            ['description', 'string', 'max' => 500],
            ['name', 'checkName'],
            ['description', 'checkDescription'],
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

    public function checkName()
    {
        if (strlen(str_replace(' ', '', $this->name)) < 10) {
            $this->addError('name', 'Поле должно содержать не менее 10 непробельных символов');
        }
    }

    public function checkDescription()
    {
        if (strlen(str_replace(' ', '', $this->description)) < 30) {
            $this->addError('description', 'Поле должно содержать не менее 30 непробельных символов');
        }
    }


}