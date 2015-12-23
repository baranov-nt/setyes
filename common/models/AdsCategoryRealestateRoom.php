<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ads_category_realestate_room".
 *
 * @property integer $id
 * @property integer $deal_type
 * @property integer $images_num
 * @property string $images_label
 * @property string $video
 * @property integer $area
 * @property integer $area_type
 * @property integer $number_room_type
 * @property integer $floor_type
 * @property integer $number_floor_type
 * @property integer $house_type
 * @property integer $period_type
 * @property string $price
 * @property string $currency
 *
 * @property AdsCategoryRealestate[] $adsCategoryRealestates
 * @property Reference $areaType
 * @property Reference $dealType
 * @property Reference $floorType
 * @property Reference $houseType
 * @property Reference $numberFloorType
 * @property Reference $numberRoomType
 * @property Reference $periodType
 */
class AdsCategoryRealestateRoom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads_category_realestate_room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deal_type', 'images_num', 'area', 'area_type', 'number_room_type', 'floor_type', 'number_floor_type', 'house_type', 'period_type'], 'integer'],
            [['price'], 'number'],
            [['currency'], 'required'],
            [['images_label'], 'string', 'max' => 32],
            [['video'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'deal_type' => Yii::t('app', 'Deal Type'),
            'images_num' => Yii::t('app', 'Images Num'),
            'images_label' => Yii::t('app', 'Images Label'),
            'video' => Yii::t('app', 'Video'),
            'area' => Yii::t('app', 'Area'),
            'area_type' => Yii::t('app', 'Area Type'),
            'number_room_type' => Yii::t('app', 'Number Room Type'),
            'floor_type' => Yii::t('app', 'Floor Type'),
            'number_floor_type' => Yii::t('app', 'Number Floor Type'),
            'house_type' => Yii::t('app', 'House Type'),
            'period_type' => Yii::t('app', 'Period Type'),
            'price' => Yii::t('app', 'Price'),
            'currency' => Yii::t('app', 'Currency'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdsCategoryRealestates()
    {
        return $this->hasMany(AdsCategoryRealestate::className(), ['room_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'area_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'deal_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloorType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'floor_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHouseType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'house_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumberFloorType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'number_floor_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumberRoomType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'number_room_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodType()
    {
        return $this->hasOne(Reference::className(), ['id' => 'period_type']);
    }
}
