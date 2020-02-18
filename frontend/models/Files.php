<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $link
 *
 * @property TasksFiles[] $tasksFiles
 * @property Users[] $users
 * @property UsersWorkPhotos[] $usersWorkPhotos
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
     * Gets query for [[TasksFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksFiles()
    {
        return $this->hasMany(TasksFiles::className(), ['file_id' => 'id']);
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
     * Gets query for [[UsersWorkPhotos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersWorkPhotos()
    {
        return $this->hasMany(UsersWorkPhotos::className(), ['file_id' => 'id']);
    }
}
