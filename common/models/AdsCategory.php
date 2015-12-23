<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ads_category".
 *
 * @property integer $id
 * @property integer $realestate_id
 * @property integer $transport_id
 * @property integer $electronics_id
 * @property integer $clothes_id
 * @property integer $work_id
 * @property integer $animals_id
 *
 * @property Ads[] $ads
 * @property AdsCategoryRealestate $realestate
 */
class AdsCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['realestate_id', 'transport_id', 'electronics_id', 'clothes_id', 'work_id', 'animals_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'realestate_id' => Yii::t('app', 'Realestate ID'),
            'transport_id' => Yii::t('app', 'Transport ID'),
            'electronics_id' => Yii::t('app', 'Electronics ID'),
            'clothes_id' => Yii::t('app', 'Clothes ID'),
            'work_id' => Yii::t('app', 'Work ID'),
            'animals_id' => Yii::t('app', 'Animals ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasMany(Ads::className(), ['categoty_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRealestate()
    {
        return $this->hasOne(AdsCategoryRealestate::className(), ['id' => 'realestate_id']);
    }
}
