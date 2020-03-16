<?php

namespace frontend\models;

use Yii;
use frontend\models\tasks\TasksFile;
use frontend\models\users\Users;
use frontend\models\users\UsersPhoto;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $link
 *
 * @property TasksFile[] $tasksId
 * @property Users[] $users
 * @property UsersPhoto[] $userPhoto
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link'], 'required'],
            [['link'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Link',
        ];
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksId()
    {
        return $this->hasMany(TasksFile::className(), ['file_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['avatar' => 'id']);
    }

    /**
     * Gets query for [[UsersPhoto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersPhoto()
    {
        return $this->hasMany(UsersPhoto::className(), ['file_id' => 'id']);
    }
}
