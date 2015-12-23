<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ads_category_realestate".
 *
 * @property integer $id
 * @property integer $room_id
 * @property integer $apartament_id
 * @property integer $house_id
 * @property integer $land_plot_id
 * @property integer $garage_id
 * @property integer $commercial_property_id
 *
 * @property AdsCategory[] $adsCategories
 * @property AdsCategoryRealestateRoom $room
 */
class AdsCategoryRealestate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads_category_realestate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_id', 'apartament_id', 'house_id', 'land_plot_id', 'garage_id', 'commercial_property_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'room_id' => Yii::t('app', 'Room ID'),
            'apartament_id' => Yii::t('app', 'Apartament ID'),
            'house_id' => Yii::t('app', 'House ID'),
            'land_plot_id' => Yii::t('app', 'Land Plot ID'),
            'garage_id' => Yii::t('app', 'Garage ID'),
            'commercial_property_id' => Yii::t('app', 'Commercial Property ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdsCategories()
    {
        return $this->hasMany(AdsCategory::className(), ['realestate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(AdsCategoryRealestateRoom::className(), ['id' => 'room_id']);
    }
}
