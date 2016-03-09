<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_model".
 *
 * @property integer $id_car_model
 * @property integer $id_car_make
 * @property string $name
 *
 * @property AdTransport[] $adTransports
 * @property CarGeneration[] $carGenerations
 * @property CarMake $idCarMake
 * @property CarSerie[] $carSeries
 * @property CarTrim[] $carTrims
 */
class CarModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_car_make'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_car_model' => Yii::t('app', 'Id Car Model'),
            'id_car_make' => Yii::t('app', 'Id Car Make'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdTransports()
    {
        return $this->hasMany(AdTransport::className(), ['id_car_model' => 'id_car_model']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarGenerations()
    {
        return $this->hasMany(CarGeneration::className(), ['id_car_model' => 'id_car_model']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCarMake()
    {
        return $this->hasOne(CarMake::className(), ['id_car_make' => 'id_car_make']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarSeries()
    {
        return $this->hasMany(CarSerie::className(), ['id_car_model' => 'id_car_model']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarTrims()
    {
        return $this->hasMany(CarTrim::className(), ['id_car_model' => 'id_car_model']);
    }
}
