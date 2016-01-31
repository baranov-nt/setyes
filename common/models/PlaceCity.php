<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "place_city".
 *
 * @property integer $id
 * @property string $place_id
 * @property integer $region_id
 *
 * @property PlaceAddress[] $placeAddresses
 * @property PlaceRegion $region
 */
class PlaceCity extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'place_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_id', 'region_id'], 'required'],
            [['region_id'], 'integer'],
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
            'region_id' => Yii::t('app', 'Region ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceAddresses()
    {
        return $this->hasMany(PlaceAddress::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(PlaceRegion::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function createCity($modelPlaceRegion, $cityPlaceId)
    {
        $modelPlaceCity = new PlaceCity();
        $modelPlaceCity->place_id = $cityPlaceId;
        $modelPlaceCity->link('region', $modelPlaceRegion);
        return $modelPlaceCity;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function createCityAndAddress($modelPlaceRegion, $cityPlaceId, $addressPlaceId)
    {
        $modelPlaceAddress = new PlaceAddress();
        $modelPlaceAddress->place_id = $addressPlaceId;
        $modelPlaceCity = new PlaceCity();
        $modelPlaceCity->place_id = $cityPlaceId;
        $modelPlaceCity->link('region', $modelPlaceRegion);
        $modelPlaceCity->link('placeAddresses', $modelPlaceAddress);
        return $modelPlaceAddress;
    }
}
