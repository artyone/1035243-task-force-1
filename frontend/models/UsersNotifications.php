<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users_notifications".
 *
 * @property int $id
 * @property int $user_id
 * @property int $new_feedback
 * @property int $new_chat
 * @property int $new_refuse
 * @property int $start_task
 * @property int $finish_task
 *
 * @property Users $user
 */
class UsersNotifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_notifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'new_feedback', 'new_chat', 'new_refuse', 'start_task', 'finish_task'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'new_feedback' => 'New Feedback',
            'new_chat' => 'New Chat',
            'new_refuse' => 'New Refuse',
            'start_task' => 'Start Task',
            'finish_task' => 'Finish Task',
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
}
