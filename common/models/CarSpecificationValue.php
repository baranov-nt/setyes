<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_specification_value".
 *
 * @property integer $id_car_specification_value
 * @property string $value
 * @property string $unit
 * @property integer $id_car_specification
 * @property integer $id_car_trim
 *
 * @property CarSpecification $idCarSpecification
 * @property CarTrim $idCarTrim
 */
class CarSpecificationValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_specification_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_car_specification', 'id_car_trim'], 'integer'],
            [['value', 'unit'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_car_specification_value' => Yii::t('app', 'Id Car Specification Value'),
            'value' => Yii::t('app', 'Value'),
            'unit' => Yii::t('app', 'Unit'),
            'id_car_specification' => Yii::t('app', 'Id Car Specification'),
            'id_car_trim' => Yii::t('app', 'Id Car Trim'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCarSpecification()
    {
        return $this->hasOne(CarSpecification::className(), ['id_car_specification' => 'id_car_specification']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCarTrim()
    {
        return $this->hasOne(CarTrim::className(), ['id_car_trim' => 'id_car_trim']);
    }
}
