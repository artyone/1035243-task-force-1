<?php

namespace frontend\models\tasks;

use Yii;
use frontend\models\users\Users;

/**
 * This is the model class for table "tasks_chat".
 *
 * @property int $id
 * @property string|null $creation_time
 * @property int $task_id
 * @property int $customer_id
 * @property int $executor_id
 * @property string $message
 * @property int|null $read
 *
 * @property Users $userCustomer
 * @property Users $userExecutor
 * @property Tasks $task
 */
class TasksChat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks_chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time'], 'safe'],
            [['task_id', 'customer_id', 'executor_id', 'message'], 'required'],
            [['task_id', 'customer_id', 'executor_id', 'read'], 'integer'],
            [['message'], 'string', 'max' => 500],
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
            [
                ['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Tasks::className(),
                'targetAttribute' => ['task_id' => 'id']
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
            'task_id' => 'Task ID',
            'customer_id' => 'Customer',
            'executor_id' => 'Executor',
            'message' => 'Message',
            'read' => 'Read',
        ];
    }

    /**
     * Gets query for [[UserCustomer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCustomer()
    {
        return $this->hasOne(Users::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[UserExecutor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserExecutor()
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