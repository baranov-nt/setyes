<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_category".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $ad_id
 *
 * @property AdReferenceMain $category
 * @property AdMain[] $adMains
 */
class AdCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'ad_id'], 'required'],
            [['category_id'], 'integer'],
            [['ad_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'ad_id' => Yii::t('app', 'Ad ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(AdReferenceMain::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdMains()
    {
        return $this->hasMany(AdMain::className(), ['ad_category_id' => 'id']);
    }
}