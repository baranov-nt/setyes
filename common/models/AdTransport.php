<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_transport".
 *
 * @property integer $id
 * @property integer $transport
 * @property integer $deal_type
 * @property integer $id_car_model
 * @property integer $mileage
 * @property integer $measurement_of_mileage
 * @property integer $price
 * @property integer $price_for_the_period
 * @property integer $equipment
 * @property integer $exterior_color
 * @property integer $interior_color
 * @property integer $condition
 * @property integer $images_label
 * @property string $video_link
 * @property string $model_scenario
 *
 * @property AdTransportReference $condition0
 * @property AdTransportReference $equipment0
 * @property AdTransportReference $exteriorColor
 * @property AdTransportReference $interiorColor
 * @property CarModel $idCarModel
 * @property AdTransportReference $dealType
 * @property AdTransportReference $measurementOfMileage
 * @property AdTransportReference $priceForThePeriod
 * @property AdTransportReference $transport0
 */
class AdTransport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_transport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transport', 'deal_type', 'id_car_model'], 'required'],
            [['transport', 'deal_type', 'id_car_model', 'mileage', 'measurement_of_mileage', 'price', 'price_for_the_period', 'equipment', 'exterior_color', 'interior_color', 'condition', 'images_label'], 'integer'],
            [['video_link', 'model_scenario'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'transport' => Yii::t('app', 'Transport'),
            'deal_type' => Yii::t('app', 'Deal Type'),
            'id_car_model' => Yii::t('app', 'Id Car Model'),
            'mileage' => Yii::t('app', 'Mileage'),
            'measurement_of_mileage' => Yii::t('app', 'Measurement Of Mileage'),
            'price' => Yii::t('app', 'Price'),
            'price_for_the_period' => Yii::t('app', 'Price For The Period'),
            'equipment' => Yii::t('app', 'Equipment'),
            'exterior_color' => Yii::t('app', 'Exterior Color'),
            'interior_color' => Yii::t('app', 'Interior Color'),
            'condition' => Yii::t('app', 'Condition'),
            'images_label' => Yii::t('app', 'Images Label'),
            'video_link' => Yii::t('app', 'Video Link'),
            'model_scenario' => Yii::t('app', 'Model Scenario'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCondition0()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'condition']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipment0()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'equipment']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExteriorColor()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'exterior_color']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInteriorColor()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'interior_color']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCarModel()
    {
        return $this->hasOne(CarModel::className(), ['id_car_model' => 'id_car_model']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealType()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'deal_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeasurementOfMileage()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'measurement_of_mileage']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriceForThePeriod()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'price_for_the_period']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransport0()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'transport']);
    }
}
