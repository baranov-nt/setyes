<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_real_estate_reference".
 *
 * @property integer $id
 * @property integer $reference_id
 * @property string $reference_name
 *
 * @property AdRealEstate[] $adRealEstates
 * @property AdRealEstate[] $adRealEstates0
 * @property AdRealEstate[] $adRealEstates1
 * @property AdRealEstate[] $adRealEstates2
 * @property AdRealEstate[] $adRealEstates3
 * @property AdRealEstate[] $adRealEstates4
 * @property AdRealEstate[] $adRealEstates5
 * @property AdRealEstate[] $adRealEstates6
 * @property AdRealEstate[] $adRealEstates7
 * @property AdRealEstate[] $adRealEstates8
 * @property AdRealEstate[] $adRealEstates9
 * @property AdRealEstate[] $adRealEstates10
 * @property AdRealEstateAppliances[] $adRealEstateAppliances
 */
class AdRealEstateReference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_real_estate_reference';
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
    public function getAdRealEstates()
    {
        return $this->hasMany(AdRealEstate::className(), ['category_land' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdRealEstates0()
    {
        return $this->hasMany(AdRealEstate::className(), ['floor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdRealEstates1()
    {
        return $this->hasMany(AdRealEstate::className(), ['floors_in_the_house' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdRealEstates2()
    {
        return $this->hasMany(AdRealEstate::className(), ['furnished' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdRealEstates3()
    {
        return $this->hasMany(AdRealEstate::className(), ['lease_term' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdRealEstates4()
    {
        return $this->hasMany(AdRealEstate::className(), ['material_housing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdRealEstates5()
    {
        return $this->hasMany(AdRealEstate::className(), ['operation_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdRealEstates6()
    {
        return $this->hasMany(AdRealEstate::className(), ['price_period' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdRealEstates7()
    {
        return $this->hasMany(AdRealEstate::className(), ['property_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdRealEstates8()
    {
        return $this->hasMany(AdRealEstate::className(), ['property_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdRealEstates9()
    {
        return $this->hasMany(AdRealEstate::className(), ['rooms_in_the_apartment' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdRealEstates10()
    {
        return $this->hasMany(AdRealEstate::className(), ['system_measure' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdRealEstateAppliances()
    {
        return $this->hasMany(AdRealEstateAppliances::className(), ['reference_id' => 'id']);
    }
}
