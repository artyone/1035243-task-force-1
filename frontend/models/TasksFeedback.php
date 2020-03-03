<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tasks_feedback".
 *
 * @property int $id
 * @property string|null $creation_time
 * @property int $customer_id
 * @property int $executor_id
 * @property int $task_id
 * @property string|null $description
 * @property int $rating
 *
 * @property Users $customer
 * @property Users $executor
 * @property Tasks $task
 */
class TasksFeedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks_feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time'], 'safe'],
            [['customer_id', 'executor_id', 'task_id', 'rating'], 'required'],
            [['customer_id', 'executor_id', 'task_id', 'rating'], 'integer'],
            [['description'], 'string', 'max' => 500],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['executor_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
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
            'customer_id' => 'Customer ID',
            'executor_id' => 'Executor ID',
            'task_id' => 'Task ID',
            'description' => 'Description',
            'rating' => 'Rating',
        ];
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
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }
}
