<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string|null $creation_time
 * @property string $name
 * @property int $category_id
 * @property int|null $location_id
 * @property int|null $latitude
 * @property int|null $longitude
 * @property string|null $address_comments
 * @property string|null $description
 * @property int|null $price
 * @property int $customer_id
 * @property int|null $executor_id
 * @property string|null $deadline_time
 * @property int $status
 *
 * @property Categories $category
 * @property Cities $location
 * @property Users $customer
 * @property Users $executor
 * @property TasksChats[] $tasksChats
 * @property TasksCompletedFeedback[] $tasksCompletedFeedbacks
 * @property TasksFiles[] $tasksFiles
 * @property TasksResponses[] $tasksResponses
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time', 'deadline_time'], 'safe'],
            [['name', 'category_id', 'customer_id'], 'required'],
            [
                [
                    'category_id',
                    'location_id',
                    'latitude',
                    'longitude',
                    'price',
                    'customer_id',
                    'executor_id',
                    'status'
                ],
                'integer'
            ],
            [['name', 'address_comments', 'description'], 'string', 'max' => 500],
            [
                ['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Categories::className(),
                'targetAttribute' => ['category_id' => 'id']
            ],
            [
                ['location_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Cities::className(),
                'targetAttribute' => ['location_id' => 'id']
            ],
            [
                ['customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::className(),
                'targetAttribute' => ['customer_id' => 'id']
            ],
            [
                ['executor_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::className(),
                'targetAttribute' => ['executor_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creation_time' => 'Creation Time',
            'name' => 'Name',
            'category_id' => 'Category ID',
            'location_id' => 'Location ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'address_comments' => 'Address Comments',
            'description' => 'Description',
            'price' => 'Price',
            'customer_id' => 'Customer ID',
            'executor_id' => 'Executor ID',
            'deadline_time' => 'Deadline Time',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Location]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Cities::className(), ['id' => 'location_id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Users::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Users::className(), ['id' => 'executor_id']);
    }

    /**
     * Gets query for [[TasksChats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksChats()
    {
        return $this->hasMany(TasksChats::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TasksCompletedFeedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksCompletedFeedbacks()
    {
        return $this->hasMany(TasksCompletedFeedback::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TasksFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksFiles()
    {
        return $this->hasMany(TasksFiles::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TasksResponses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksResponses()
    {
        return $this->hasMany(TasksResponses::className(), ['task_id' => 'id']);
    }

}