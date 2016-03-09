<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_generation".
 *
 * @property integer $id_car_generation
 * @property string $name
 * @property integer $id_car_model
 * @property string $year_begin
 * @property string $year_end
 *
 * @property CarModel $idCarModel
 * @property CarSerie[] $carSeries
 */
class CarGeneration extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_generation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_car_model'], 'integer'],
            [['name', 'year_begin', 'year_end'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_car_generation' => Yii::t('transport', 'Id Car Generation'),
            'name' => Yii::t('transport', 'Name'),
            'id_car_model' => Yii::t('transport', 'Id Car Model'),
            'year_begin' => Yii::t('transport', 'Year Begin'),
            'year_end' => Yii::t('transport', 'Year End'),
        ];
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
    public function getCarSeries()
    {
        return $this->hasMany(CarSerie::className(), ['id_car_generation' => 'id_car_generation']);
    }
}
