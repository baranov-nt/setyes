<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "place_address".
 *
 * @property integer $id
 * @property string $place_id
 * @property integer $city_id
 *
 * @property PlaceCity $city
 */
class PlaceAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'place_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_id', 'city_id'], 'required'],
            [['city_id'], 'integer'],
            [['place_id'], 'string', 'max' => 32]
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
        return $this->hasOne(PlaceCity::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function createAddress($modelPlaceCity, $addressPlaceId)
    {
        $modelPlaceAddress = new PlaceAddress();
        $modelPlaceAddress->place_id = $addressPlaceId;
        $modelPlaceAddress->link('city', $modelPlaceCity);
        return $modelPlaceAddress;
    }
}
