<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "locations".
 *
 * @property int $id
 * @property int $country_id
 * @property int $city_id
 * @property string|null $location
 *
 * @property Countries $country
 * @property Cities $city
 * @property UsersData[] $usersDatas
 */
class Locations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'locations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_id', 'city_id'], 'required'],
            [['country_id', 'city_id'], 'integer'],
            [['location'], 'string', 'max' => 500],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['country_id' => 'id']],
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
            'country_id' => 'Country ID',
            'city_id' => 'City ID',
            'location' => 'Location',
        ];
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['id' => 'country_id']);
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

    /**
     * Gets query for [[UsersDatas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersDatas()
    {
        return $this->hasMany(UsersData::className(), ['location_id' => 'id']);
    }
}
