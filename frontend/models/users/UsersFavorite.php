<?php

namespace frontend\models\users;

use Yii;

/**
 * This is the model class for table "users_favorite".
 *
 * @property int $id
 * @property int $user_id
 * @property int $favorite_id
 *
 * @property Users $user
 * @property Users $favorite
 */
class UsersFavorite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_favorite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'favorite_id'], 'required'],
            [['user_id', 'favorite_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['favorite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['favorite_id' => 'id']],
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
            'favorite_id' => 'Favorite ID',
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
     * Gets query for [[Favorite]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorite()
    {
        return $this->hasOne(Users::className(), ['id' => 'favorite_id']);
    }
}
