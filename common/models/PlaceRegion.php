<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "place_region".
 *
 * @property integer $id
 * @property string $place_id
 * @property integer $country_id
 *
 * @property PlaceCity[] $placeCities
 * @property PlaceCountry $country
 */
class PlaceRegion extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'place_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id'], 'required'],
            [['country_id'], 'integer'],
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
            'country_id' => Yii::t('app', 'Country ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceCities()
    {
        return $this->hasMany(PlaceCity::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(PlaceCountry::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function createRegionAndCity($modelPlaceCountry, $regionPlaceId, $cityPlaceId)
    {
        $modelPlaceRegion = new PlaceRegion();
        $modelPlaceRegion->place_id = $regionPlaceId;
        $modelPlaceRegion->link('country', $modelPlaceCountry);
        $modelCity = new PlaceCity();
        $modelCity->place_id = $cityPlaceId;
        $modelCity->link('region', $modelPlaceRegion);
        return $modelCity;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function createRegionAndCityAndAddress($modelPlaceCountry, $regionPlaceId, $cityPlaceId, $addressPlaceId)
    {
        $modelPlaceRegion = new PlaceRegion();
        $modelPlaceRegion->place_id = $regionPlaceId;
        $modelPlaceRegion->link('country', $modelPlaceCountry);
        $modelPlaceCity = new PlaceCity();
        $modelPlaceCity->place_id = $cityPlaceId;
        $modelPlaceCity->link('region', $modelPlaceRegion);
        $modelPlaceAddress = new PlaceAddress();
        $modelPlaceAddress->place_id = $addressPlaceId;
        $modelPlaceCity->link('placeAddresses', $modelPlaceCity);
        return $modelPlaceAddress;
    }
}
