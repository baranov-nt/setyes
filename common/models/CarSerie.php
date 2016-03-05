<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_serie".
 *
 * @property integer $id_car_serie
 * @property integer $id_car_model
 * @property string $name
 * @property integer $id_car_generation
 *
 * @property CarGeneration $idCarGeneration
 * @property CarModel $idCarModel
 * @property CarTrim[] $carTrims
 */
class CarSerie extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_serie';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_car_model', 'id_car_generation'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_car_serie' => Yii::t('app', 'Id Car Serie'),
            'id_car_model' => Yii::t('app', 'Id Car Model'),
            'name' => Yii::t('app', 'Name'),
            'id_car_generation' => Yii::t('app', 'Id Car Generation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCarGeneration()
    {
        return $this->hasOne(CarGeneration::className(), ['id_car_generation' => 'id_car_generation']);
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
    public function getCarTrims()
    {
        return $this->hasMany(CarTrim::className(), ['id_car_serie' => 'id_car_serie']);
    }
}
