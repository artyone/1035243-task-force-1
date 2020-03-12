<?php

namespace frontend\models;

use Yii;
use frontend\models\tasks\Tasks;
use frontend\models\users\UsersData;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string $name
 *
 * @property Tasks[] $tasks
 * @property UsersData[] $userData
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name'
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['city_id' => 'id']);
    }

    /**
     * Gets query for [[UsersData]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersData()
    {
        return $this->hasMany(UsersData::className(), ['city_id' => 'id']);
    }
}


