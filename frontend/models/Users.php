<?php

namespace frontend\models;

use Yii;
use frontend\models\Tasks;

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
 * @property Tasks[] $tasksCustomer
 * @property Tasks[] $tasksExecutor
 * @property TasksChat[] $tasksChatCustomer
 * @property TasksChat[] $tasksChatExecutor
 * @property TasksFeedback[] $tasksFeedbackCustomer
 * @property TasksFeedback[] $tasksFeedbackExecutor
 * @property TasksResponse[] $tasksResponseExecutor
 * @property Files $fileAvatar
 * @property UsersCategory[] $userCategories
 * @property UsersData[] $userData
 * @property UsersFavorite[] $usersFavorite
 * @property UsersFavorite[] $usersInFavorite
 * @property UsersNotification[] $usersNotification
 * @property UsersVisible[] $usersVisible
 * @property UsersPhoto[] $usersPhoto
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
            [['password_hash'], 'string', 'max' => 64],
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
     * Gets query for [[TasksCustomer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksCustomer()
    {
        return $this->hasMany(Tasks::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[TasksExecutor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksExecutor()
    {
        return $this->hasMany(Tasks::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[TasksChatsCustomer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksChatCustomer()
    {
        return $this->hasMany(TasksChat::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[TasksChatExecutor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksChatExecutor()
    {
        return $this->hasMany(TasksChat::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[TasksFeedbackCustomer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksFeedbackCustomer()
    {
        return $this->hasMany(TasksFeedback::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[TasksFeedbackExecutor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksFeedbackExecutor()
    {
        return $this->hasMany(TasksFeedback::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[TasksResponseExecutor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksResponseExecutor()
    {
        return $this->hasMany(TasksResponse::className(), ['executor_id' => 'id']);
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
     * Gets query for [[UsersFavorite]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersFavorite()
    {
        return $this->hasMany(UsersFavorite::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersInFavorite]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersInFavorite()
    {
        return $this->hasMany(UsersFavorite::className(), ['favorite_id' => 'id']);
    }

    /**
     * Gets query for [[UsersNotification]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersNotification()
    {
        return $this->hasMany(UsersNotification::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersVisible]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersVisible()
    {
        return $this->hasMany(UsersVisible::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersPhoto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersPhoto()
    {
        return $this->hasMany(Files::className(), ['id' => 'file_id'])
            ->viaTable('users_photo', ['user_id' => 'id']);
    }

    /**
     * Gets rating user
     *
     * @return int
     */
    public function getRatingByFeedback(): int
    {
        if ($count = count($this->tasksFeedbackExecutor)) {

            $allRating = 0;
            foreach ($this->tasksFeedbackExecutor as $feedback) {
                $allRating += $feedback->rating;
            }
            $rating = round($allRating / $count, 2);
        } else {
            $rating = 0;
        }

        return $rating;
    }

    /**
     * Gets query completed tasks for user
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCompletedTasksExecutor()
    {
        return $this->getTasksExecutor()->where(['status' => Tasks::STATUS_DONE])->all();
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
}
