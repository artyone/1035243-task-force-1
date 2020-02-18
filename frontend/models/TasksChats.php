<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tasks_chats".
 *
 * @property int $id
 * @property string|null $creation_time
 * @property int $task_id
 * @property int $sender
 * @property int $recipient
 * @property string $message
 * @property int|null $read
 *
 * @property Users $sender0
 * @property Users $recipient0
 * @property Tasks $task
 */
class TasksChats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks_chats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time'], 'safe'],
            [['task_id', 'sender', 'recipient', 'message'], 'required'],
            [['task_id', 'sender', 'recipient', 'read'], 'integer'],
            [['message'], 'string', 'max' => 500],
            [['sender'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['sender' => 'id']],
            [['recipient'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['recipient' => 'id']],
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
            'task_id' => 'Task ID',
            'sender' => 'Sender',
            'recipient' => 'Recipient',
            'message' => 'Message',
            'read' => 'Read',
        ];
    }

    /**
     * Gets query for [[Sender0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSender0()
    {
        return $this->hasOne(Users::className(), ['id' => 'sender']);
    }

    /**
     * Gets query for [[Recipient0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient0()
    {
        return $this->hasOne(Users::className(), ['id' => 'recipient']);
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
