<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_specification".
 *
 * @property integer $id_car_specification
 * @property string $name
 * @property integer $id_parent
 *
 * @property CarSpecificationValue[] $carSpecificationValues
 */
class CarSpecification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_specification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_parent'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_car_specification' => Yii::t('transport', 'Id Car Specification'),
            'name' => Yii::t('transport', 'Name'),
            'id_parent' => Yii::t('transport', 'Id Parent'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarSpecificationValues()
    {
        return $this->hasMany(CarSpecificationValue::className(), ['id_car_specification' => 'id_car_specification']);
    }
}
