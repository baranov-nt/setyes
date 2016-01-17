<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_real_estate_appliances".
 *
 * @property integer $id
 * @property integer $reference_id
 * @property integer $real_estate_id
 *
 * @property AdRealEstate $realEstate
 * @property AdRealEstateReference $reference
 */
class AdRealEstateAppliances extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_real_estate_appliances';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reference_id', 'real_estate_id'], 'required'],
            [['reference_id', 'real_estate_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'reference_id' => Yii::t('app', 'Reference ID'),
            'real_estate_id' => Yii::t('app', 'Real Estate ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRealEstate()
    {
        return $this->hasOne(AdRealEstate::className(), ['id' => 'real_estate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReference()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'reference_id']);
    }
}
