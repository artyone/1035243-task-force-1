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
 * @property Tasks[] $taskCustomer
 * @property Tasks[] $tasksExecutor
 * @property TasksChats[] $tasksChatsSender
 * @property TasksChats[] $tasksChatsRecipient
 * @property TasksCompletedFeedback[] $taskCompletedFeedbackExecutor
 * @property TasksCompletedFeedback[] $taskCompletedFeedbackCommentator
 * @property TasksResponses[] $taskResponses
 * @property Files $fileAvatar
 * @property UsersCategory[] $userCategories
 * @property UsersData[] $userData
 * @property UsersFavorites[] $userFavorites
 * @property UsersFavorites[] $userInFavorites
 * @property UsersNotifications[] $userNotifications
 * @property UsersVisible[] $usersVisible
 * @property UsersWorkPhotos[] $userWorkPhotos
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
            [
                ['avatar'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Files::className(),
                'targetAttribute' => ['avatar' => 'id']
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
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'name' => 'Name',
            'creation_time' => 'Creation Time',
            'avatar' => 'Avatar',
        ];
    }

    /**
     * Gets query for [[TaskCustomer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskCustomer()
    {
        return $this->hasMany(Tasks::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[TaskExecutor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskExecutor()
    {
        return $this->hasMany(Tasks::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[TasksChatsSender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksChatsSender()
    {
        return $this->hasMany(TasksChats::className(), ['sender' => 'id']);
    }

    /**
     * Gets query for [[TaskChatRecipient]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskChatRecipient()
    {
        return $this->hasMany(TasksChats::className(), ['recipient' => 'id']);
    }

    /**
     * Gets query for [[TaskCompletedFeedbackExecutor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskCompletedFeedbackExecutor()
    {
        return $this->hasMany(TasksCompletedFeedback::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[TaskCompletedFeedbackCommentator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskCompletedFeedbackCommentator()
    {
        return $this->hasMany(TasksCompletedFeedback::className(), ['commentator_id' => 'id']);
    }

    /**
     * Gets query for [[TaskResponses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskResponses()
    {
        return $this->hasMany(TasksResponses::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[FileAvatar]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFileAvatar()
    {
        return $this->hasOne(Files::className(), ['id' => 'avatar']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getUserCategories()
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id'])
            ->viaTable('users_category', ['user_id' => 'id']);
    }


    /**
     * Gets query for [[UserData]].
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
     * Gets query for [[UsersInFavorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserInFavorites()
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
     * Gets query for [[UsersVisible]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserVisible()
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

    public function getRating()
    {
        if ($count = count($this->taskCompletedFeedbackExecutor)) {

            $allRating = 0;
            foreach ($this->taskCompletedFeedbackExecutor as $feedback) {
                $allRating += $feedback->rating;
            }
            $rating = $allRating / $count;
        } else {
            $rating = 0;
        }

        return $rating;
    }

    public function getCompletedTaskExecutor()
    {
        return $this->getTaskExecutor()->where(['status' => 5])->all();

    }
}
