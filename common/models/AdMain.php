<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_main".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $place_city_id
 * @property integer $ad_category_id
 * @property integer $ad_style_id
 *
 * @property AdCategory $adCategory
 * @property PlaceCity $placeCity
 * @property AdStyle $adStyle
 * @property User $user
 */
class AdMain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_main';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'ad_category_id'], 'required'],
            [['user_id', 'place_city_id', 'ad_category_id', 'ad_style_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'place_city_id' => Yii::t('app', 'Place City ID'),
            'ad_category_id' => Yii::t('app', 'Ad Category ID'),
            'ad_style_id' => Yii::t('app', 'Ad Style ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdCategory()
    {
        return $this->hasOne(AdCategory::className(), ['id' => 'ad_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceCity()
    {
        return $this->hasOne(PlaceCity::className(), ['id' => 'place_city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdStyle()
    {
        return $this->hasOne(AdStyle::className(), ['id' => 'ad_style_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
