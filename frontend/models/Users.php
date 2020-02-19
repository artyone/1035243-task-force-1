<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $password_hash
 * @property string|null $name
 * @property string|null $creation_time
 * @property int|null $avatar
 *
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property TasksChats[] $tasksChats
 * @property TasksChats[] $tasksChats0
 * @property TasksCompletedFeedback[] $tasksCompletedFeedbacks
 * @property TasksCompletedFeedback[] $tasksCompletedFeedbacks0
 * @property TasksResponses[] $tasksResponses
 * @property Files $avatar0
 * @property UsersCategory[] $usersCategories
 * @property UsersData[] $usersDatas
 * @property UsersFavorites[] $usersFavorites
 * @property UsersFavorites[] $usersFavorites0
 * @property UsersNotifications[] $usersNotifications
 * @property UsersVisible[] $usersVisibles
 * @property UsersWorkPhotos[] $usersWorkPhotos
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password_hash'], 'required'],
            [['creation_time'], 'safe'],
            [['avatar'], 'integer'],
            [['email'], 'string', 'max' => 254],
            [['password_hash'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 500],
            [['email'], 'unique'],
            [['avatar'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['avatar' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'name' => 'Name',
            'creation_time' => 'Creation Time',
            'avatar' => 'Avatar',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[TasksChats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksChats()
    {
        return $this->hasMany(TasksChats::className(), ['sender' => 'id']);
    }

    /**
     * Gets query for [[TasksChats0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksChats0()
    {
        return $this->hasMany(TasksChats::className(), ['recipient' => 'id']);
    }

    /**
     * Gets query for [[TasksCompletedFeedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksCompletedFeedbacks()
    {
        return $this->hasMany(TasksCompletedFeedback::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[TasksCompletedFeedbacks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksCompletedFeedbacks0()
    {
        return $this->hasMany(TasksCompletedFeedback::className(), ['commentators_id' => 'id']);
    }

    /**
     * Gets query for [[TasksResponses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksResponses()
    {
        return $this->hasMany(TasksResponses::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Avatar0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvatar0()
    {
        return $this->hasOne(Files::className(), ['id' => 'avatar']);
    }

    /**
     * Gets query for [[UsersCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UsersCategory::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersData]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserData()
    {
        return $this->hasOne(UsersData::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersFavorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFavorites()
    {
        return $this->hasMany(UsersFavorites::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersFavorites0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFavorites0()
    {
        return $this->hasMany(UsersFavorites::className(), ['favorite_id' => 'id']);
    }

    /**
     * Gets query for [[UsersNotifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserNotifications()
    {
        return $this->hasMany(UsersNotifications::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersVisibles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserVisibles()
    {
        return $this->hasMany(UsersVisible::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersWorkPhotos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserWorkPhotos()
    {
        return $this->hasMany(UsersWorkPhotos::className(), ['user_id' => 'id']);
    }

    private function getTimeHoursAgo()
    {
        $time = strtotime("now") - strtotime($this->creation_time);
        $time = $time/60/60;
        return $time;
    }

    public function getStringHoursAgo()
    {
        $endingArray = ['менее часа назад',' час назад',' часа назад', ' часов назад', 'больше суток назад'];

        $number = $this->getTimeHoursAgo() % 100;

        if ($number == 0) {
            $ending=$endingArray[0];
            return $ending;
        }

        if ($number > 23) {
            $ending=$endingArray[4];
            return $ending;
        }

        if ($number>=11 && $number<=19) {
            $ending=$endingArray[3];
        }
        else {
            $i = $number % 10;
            switch ($i)
            {
                case (1): $ending = $endingArray[1]; break;
                case (2):
                case (3):
                case (4): $ending = $endingArray[2]; break;
                default: $ending = $endingArray[3];
            }
        }
        return ($number . $ending);
    }
}
