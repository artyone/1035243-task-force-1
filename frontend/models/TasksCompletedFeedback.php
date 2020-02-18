<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tasks_completed_feedback".
 *
 * @property int $id
 * @property string|null $creation_time
 * @property int $user_id
 * @property int $commentators_id
 * @property int $task_id
 * @property string|null $description
 * @property int $rating
 *
 * @property Users $user
 * @property Users $commentators
 * @property Tasks $task
 */
class TasksCompletedFeedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks_completed_feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time'], 'safe'],
            [['user_id', 'commentators_id', 'task_id', 'rating'], 'required'],
            [['user_id', 'commentators_id', 'task_id', 'rating'], 'integer'],
            [['description'], 'string', 'max' => 500],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['commentators_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['commentators_id' => 'id']],
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
            'user_id' => 'User ID',
            'commentators_id' => 'Commentators ID',
            'task_id' => 'Task ID',
            'description' => 'Description',
            'rating' => 'Rating',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Commentators]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCommentators()
    {
        return $this->hasOne(Users::className(), ['id' => 'commentators_id']);
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
