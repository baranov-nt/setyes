<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ad_real_estate".
 *
 * @property integer $id
 * @property integer $property
 * @property integer $property_type
 * @property integer $category_land
 * @property integer $operation_type
 * @property integer $rooms_in_the_apartment
 * @property integer $material_housing
 * @property integer $floor
 * @property integer $floors_in_the_house
 * @property integer $area
 * @property integer $system_measure
 * @property integer $lease_term
 * @property integer $price
 * @property integer $price_period
 * @property integer $furnished
 * @property integer $internet
 * @property integer $condition
 *
 * @property AdRealEstateReference $categoryLand
 * @property AdRealEstateReference $floor0
 * @property AdRealEstateReference $floorsInTheHouse
 * @property AdRealEstateReference $furnished0
 * @property AdRealEstateReference $leaseTerm
 * @property AdRealEstateReference $materialHousing
 * @property AdRealEstateReference $operationType
 * @property AdRealEstateReference $pricePeriod
 * @property AdRealEstateReference $propertyType
 * @property AdRealEstateReference $propertyType0
 * @property AdRealEstateReference $roomsInTheApartment
 * @property AdRealEstateReference $systemMeasure
 * @property AdRealEstateAppliances[] $adRealEstateAppliances
 */
class AdRealEstate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_real_estate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property', 'property_type', 'category_land', 'operation_type', 'rooms_in_the_apartment', 'material_housing', 'floor', 'floors_in_the_house', 'system_measure', 'lease_term', 'price_period', 'furnished', 'internet', 'condition'], 'required'],
            [['property', 'property_type', 'category_land', 'operation_type', 'rooms_in_the_apartment', 'material_housing', 'floor', 'floors_in_the_house', 'area', 'system_measure', 'lease_term', 'price', 'price_period', 'furnished', 'internet', 'condition'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'property' => Yii::t('app', 'Property'),
            'property_type' => Yii::t('app', 'Property Type'),
            'category_land' => Yii::t('app', 'Category Land'),
            'operation_type' => Yii::t('app', 'Operation Type'),
            'rooms_in_the_apartment' => Yii::t('app', 'Rooms In The Apartment'),
            'material_housing' => Yii::t('app', 'Material Housing'),
            'floor' => Yii::t('app', 'Floor'),
            'floors_in_the_house' => Yii::t('app', 'Floors In The House'),
            'area' => Yii::t('app', 'Area'),
            'system_measure' => Yii::t('app', 'System Measure'),
            'lease_term' => Yii::t('app', 'Lease Term'),
            'price' => Yii::t('app', 'Price'),
            'price_period' => Yii::t('app', 'Price Period'),
            'furnished' => Yii::t('app', 'Furnished'),
            'internet' => Yii::t('app', 'Internet'),
            'condition' => Yii::t('app', 'Condition'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryLand()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'category_land']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloor0()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'floor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloorsInTheHouse()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'floors_in_the_house']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFurnished0()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'furnished']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeaseTerm()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'lease_term']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialHousing()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'material_housing']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperationType()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'operation_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPricePeriod()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'price_period']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyType()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'property_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyType0()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'property_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomsInTheApartment()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'rooms_in_the_apartment']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystemMeasure()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'system_measure']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdRealEstateAppliances()
    {
        return $this->hasMany(AdRealEstateAppliances::className(), ['real_estate_id' => 'id']);
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstatePropertyList()
    {
        $realEstateProperty = ArrayHelper::map(AdRealEstateReference::find()
            ->where(['reference_id' => 8])
            ->all(), 'id', 'reference_name');

        $items = [];
        foreach($realEstateProperty as $key => $value):
            switch ($key) {
                case 1:
                    $items[] = [
                        'label' => Yii::t('references', $value),
                        'url' => ['/ad/real-estate/create-rooms'],
                    ];
                    break;
                case 2:
                    $items[] = [
                        'label' => Yii::t('references', $value),
                        'url' => ['/ad/real-estate/create-apartrments'],
                    ];
                    break;
                case 3:
                    $items[] = [
                        'label' => Yii::t('references', $value),
                        'url' => ['/ad/real-estate/create-houses-cottages'],
                    ];
                    break;
                case 4:
                    $items[] = [
                        'label' => Yii::t('references', $value),
                        'url' => ['/ad/real-estate/create-land-plot'],
                    ];
                    break;
                case 5:
                    $items[] = [
                        'label' => Yii::t('references', $value),
                        'url' => ['/ad/real-estate/create-garages-parking'],
                    ];
                    break;
                case 6:
                    $items[] = [
                        'label' => Yii::t('references', $value),
                        'url' => ['/ad/real-estate/create-property-abroad'],
                    ];
                    break;
                case 7:
                    $items[] = [
                        'label' => Yii::t('references', $value),
                        'url' => ['/ad/real-estate/create-commercial-property'],
                    ];
                    break;
            }
        endforeach;

        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstatePropertyTypeList($property)
    {
        switch ($property) {
            case 2:
                $property_types = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 16])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($property_types as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 3:
                $property_types = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 17])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($property_types as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 4:
                $property_types = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 18])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($property_types as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 5:
                $property_types = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 19])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($property_types as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 6:
                $property_types = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 20])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($property_types as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 7:
                $property_types = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 21])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($property_types as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
        }

        return false;
    }
}
