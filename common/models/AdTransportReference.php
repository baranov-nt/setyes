<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_transport_reference".
 *
 * @property integer $id
 * @property integer $reference_id
 * @property string $reference_name
 *
 * @property AdTransport[] $adTransports
 * @property AdTransport[] $adTransports0
 * @property AdTransport[] $adTransports1
 */
class AdTransportReference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_transport_reference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reference_id', 'reference_name'], 'required'],
            [['reference_id'], 'integer'],
            [['reference_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('transport', 'ID'),
            'reference_id' => Yii::t('transport', 'Reference ID'),
            'reference_name' => Yii::t('transport', 'Reference Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdTransports()
    {
        return $this->hasMany(AdTransport::className(), ['deal_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdTransports0()
    {
        return $this->hasMany(AdTransport::className(), ['measurement_of_mileage' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdTransports1()
    {
        return $this->hasMany(AdTransport::className(), ['transport' => 'id']);
    }
}
