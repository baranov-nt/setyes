<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_style".
 *
 * @property integer $id
 * @property string $name
 * @property string $main_container_class
 * @property string $header_link_class
 * @property string $favorite_icon
 * @property string $quick_view_class
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
            [['name', 'main_container_class', 'header_link_class', 'quick_view_class'], 'string', 'max' => 32],
            [['favorite_icon'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'main_container_class' => Yii::t('app', 'Main Container Class'),
            'header_link_class' => Yii::t('app', 'Header Link Class'),
            'favorite_icon' => Yii::t('app', 'Favorite Icon'),
            'quick_view_class' => Yii::t('app', 'Quick View Class'),
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
