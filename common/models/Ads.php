<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ads".
 *
 * @property integer $id
 * @property integer $place_id
 * @property integer $user_id
 * @property integer $style_id
 * @property integer $categoty_id
 * @property integer $checked
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AdsCategory $categoty
 * @property Place $place
 * @property AdsStyle $style
 * @property User $user
 */
class Ads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_id', 'user_id', 'categoty_id', 'created_at', 'updated_at'], 'required'],
            [['place_id', 'user_id', 'style_id', 'categoty_id', 'checked', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'place_id' => Yii::t('app', 'Place ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'style_id' => Yii::t('app', 'Style ID'),
            'categoty_id' => Yii::t('app', 'Categoty ID'),
            'checked' => Yii::t('app', 'Checked'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoty()
    {
        return $this->hasOne(AdsCategory::className(), ['id' => 'categoty_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlace()
    {
        return $this->hasOne(Place::className(), ['id' => 'place_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStyle()
    {
        return $this->hasOne(AdsStyle::className(), ['id' => 'style_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
