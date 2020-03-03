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
 * @property int|null $city_id
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
 * @property Cities $city
 * @property Users $customer
 * @property Users $executor
 * @property TasksChat[] $taskChat
 * @property TasksFeedback[] $tasksFeedback
 * @property TasksFile[] $tasksFile
 * @property TasksResponse[] $tasksResponse
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
                    'city_id',
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
                ['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Cities::className(),
                'targetAttribute' => ['city_id' => 'id']
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
            'city_id' => 'City ID',
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
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
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
     * Gets query for [[TaskChat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskChat()
    {
        return $this->hasMany(TasksChat::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TasksFeedback]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksFeedback()
    {
        return $this->hasOne(TasksFeedback::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TasksFile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksFile()
    {
        return $this->hasMany(TasksFile::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TasksResponse]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksResponse()
    {
        return $this->hasMany(TasksResponse::className(), ['task_id' => 'id']);
    }

}