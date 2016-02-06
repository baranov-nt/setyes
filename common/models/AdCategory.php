<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_category".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $ad_id
 *
 * @property AdReferenceMain $category
 * @property AdRealEstate $ad
 * @property AdMain[] $adMains
 * @property ImagesOfObject[] $imagesOfObjects
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
            [['category'], 'required'],
            [['category', 'ad_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category' => Yii::t('app', 'Category ID'),
            'ad_id' => Yii::t('app', 'Ad ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(AdReferenceMain::className(), ['id' => 'category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAd()
    {
        return $this->hasOne(AdRealEstate::className(), ['id' => 'ad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdMains()
    {
        return $this->hasMany(AdMain::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagesOfObjects()
    {
        return $this->hasMany(ImagesOfObject::className(),
            [
                'object_id' => 'id',
                'label' => 'category'
            ]);
    }
}
