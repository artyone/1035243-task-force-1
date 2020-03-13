<?php

namespace frontend\models\tasks;

use yii\base\Model;
use yii\web\UploadedFile;

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
            ['name', 'string', 'min' => 10],
            ['name', 'string', 'max' => 50],
            ['description', 'string', 'min' => 30],
            ['description', 'string', 'min' => 50],
            ['categoryId', 'exist', 'targetClass' => '\frontend\models\Categories', 'targetAttribute' => 'id','message' => 'Выбрана неверная категория'],
            ['files', 'file', 'maxFiles' => 4],
            ['price', 'integer', 'min' => '1'],
            ['deadlineTime', 'date', 'min' => time()],
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

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->files as $file) {
                $file->saveAs('taskfiles/' . $file->baseName . time() . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }


}