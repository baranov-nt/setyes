<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_reference_main".
 *
 * @property integer $id
 * @property integer $reference_id
 * @property string $reference_name
 *
 * @property AdCategory[] $adCategories
 */
class AdReferenceMain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_reference_main';
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
            'id' => Yii::t('app', 'ID'),
            'reference_id' => Yii::t('app', 'Reference ID'),
            'reference_name' => Yii::t('app', 'Reference Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdCategories()
    {
        return $this->hasMany(AdCategory::className(), ['category_id' => 'id']);
    }
}
