<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ads_style".
 *
 * @property integer $id
 * @property string $background_color
 * @property string $border_color
 * @property string $font_family
 * @property string $font_style
 * @property string $font_color
 *
 * @property Ads[] $ads
 */
class AdsStyle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads_style';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['background_color', 'border_color', 'font_color'], 'string', 'max' => 7],
            [['font_family', 'font_style'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'background_color' => Yii::t('app', 'Background Color'),
            'border_color' => Yii::t('app', 'Border Color'),
            'font_family' => Yii::t('app', 'Font Family'),
            'font_style' => Yii::t('app', 'Font Style'),
            'font_color' => Yii::t('app', 'Font Color'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasMany(Ads::className(), ['style_id' => 'id']);
    }
}
