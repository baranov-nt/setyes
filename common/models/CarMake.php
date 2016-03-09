<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_make".
 *
 * @property integer $id_car_make
 * @property string $name
 *
 * @property CarModel[] $carModels
 */
class CarMake extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_make';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_car_make' => Yii::t('transport', 'Id Car Make'),
            'name' => Yii::t('transport', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarModels()
    {
        return $this->hasMany(CarModel::className(), ['id_car_make' => 'id_car_make']);
    }
}
