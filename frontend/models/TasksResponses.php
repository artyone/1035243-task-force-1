<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tasks_responses".
 *
 * @property int $id
 * @property string|null $creation_time
 * @property int $task_id
 * @property int $executor_id
 * @property string|null $description
 * @property int|null $price
 *
 * @property Tasks $task
 * @property Users $executor
 */
class TasksResponses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks_responses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time'], 'safe'],
            [['task_id', 'executor_id'], 'required'],
            [['task_id', 'executor_id', 'price'], 'integer'],
            [['description'], 'string', 'max' => 500],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['executor_id' => 'id']],
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
            'executor_id' => 'Executor ID',
            'description' => 'Description',
            'price' => 'Price',
        ];
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

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Users::className(), ['id' => 'executor_id']);
    }
}
