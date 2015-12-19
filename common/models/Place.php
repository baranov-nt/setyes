<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "place".
 *
 * @property integer $id
 * @property string $place_id
 * @property integer $city_id
 *
 * @property City $city
 */
class Place extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'place';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_id', 'city_id'], 'required'],
            [['city_id'], 'integer'],
            [['place_id'], 'string', 'max' => 32],
            [['place_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'place_id' => Yii::t('app', 'Place ID'),
            'city_id' => Yii::t('app', 'City ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
}
