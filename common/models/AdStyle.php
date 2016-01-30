<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_style".
 *
 * @property integer $id
 * @property string $background-color
 * @property string $bоrder-color
 * @property integer $border-weight
 * @property string $header-color
 * @property string $text-color
 * @property integer $font-weight
 * @property string $font-family
 * @property string $font-family-style
 *
 * @property AdMain[] $adMains
 */
class AdStyle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_style';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['border-weight', 'font-weight'], 'integer'],
            [['background-color', 'bоrder-color', 'header-color', 'text-color', 'font-family', 'font-family-style'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'background-color' => Yii::t('app', 'Background Color'),
            'bоrder-color' => Yii::t('app', 'Bоrder Color'),
            'border-weight' => Yii::t('app', 'Border Weight'),
            'header-color' => Yii::t('app', 'Header Color'),
            'text-color' => Yii::t('app', 'Text Color'),
            'font-weight' => Yii::t('app', 'Font Weight'),
            'font-family' => Yii::t('app', 'Font Family'),
            'font-family-style' => Yii::t('app', 'Font Family Style'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdMains()
    {
        return $this->hasMany(AdMain::className(), ['ad_style_id' => 'id']);
    }
}
