<?php

namespace frontend\models\users;

use Yii;
use frontend\models\Cities;

/**
 * This is the model class for table "users_data".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $city_id
 * @property int $rating
 * @property int $popularity
 * @property int $tasks_count
 * @property string|null $address
 * @property string|null $birthday
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $about
 * @property string|null $last_online_time
 *
 * @property Users $user
 * @property Cities $city
 */
class UsersData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'city_id','rating','popularity','tasks_count'], 'integer'],
            [['birthday', 'last_online_time'], 'safe'],
            [['address', 'about'], 'string', 'max' => 500],
            [['phone'], 'string', 'max' => 20],
            [['skype'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
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
            'city_id' => 'City ID',
            'rating' => 'Rating',
            'popularity' => 'Popularity',
            'tasks_count' => 'Tasks count',
            'address' => 'Address',
            'birthday' => 'Birthday',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'about' => 'About',
            'last_online_time' => 'Last Online Time',
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
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }
}
