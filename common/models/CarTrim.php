<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_trim".
 *
 * @property integer $id_car_trim
 * @property integer $id_car_serie
 * @property integer $id_car_model
 * @property string $name
 * @property integer $start_production_year
 * @property integer $end_production_year
 * @property integer $price_min
 * @property integer $price_max
 *
 * @property CarSpecificationValue[] $carSpecificationValues
 * @property CarModel $idCarModel
 * @property CarSerie $idCarSerie
 */
class CarTrim extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_trim';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_car_serie', 'id_car_model', 'start_production_year', 'end_production_year', 'price_min', 'price_max'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_car_trim' => Yii::t('transport', 'Id Car Trim'),
            'id_car_serie' => Yii::t('transport', 'Id Car Serie'),
            'id_car_model' => Yii::t('transport', 'Id Car Model'),
            'name' => Yii::t('transport', 'Name'),
            'start_production_year' => Yii::t('transport', 'Start Production Year'),
            'end_production_year' => Yii::t('transport', 'End Production Year'),
            'price_min' => Yii::t('transport', 'Price Min'),
            'price_max' => Yii::t('transport', 'Price Max'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarSpecificationValues()
    {
        return $this->hasMany(CarSpecificationValue::className(), ['id_car_trim' => 'id_car_trim']);
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
    public function getIdCarSerie()
    {
        return $this->hasOne(CarSerie::className(), ['id_car_serie' => 'id_car_serie']);
    }
}
