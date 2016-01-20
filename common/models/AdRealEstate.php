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
 * @property integer $necessary_furniture
 * @property integer $internet
 * @property integer $condition
 *
 * @property AdRealEstateReference $categoryLand
 * @property AdRealEstateReference $floor0
 * @property AdRealEstateReference $floorsInTheHouse
 * @property AdRealEstateReference $necessary_furniture0
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
    public $currency;
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
            [['property', 'property_type', 'operation_type', 'rooms_in_the_apartment', 'material_housing', 'floor', 'floors_in_the_house', 'system_measure', 'lease_term',
                'price_period', 'necessary_furniture', 'internet', 'condition', 'currency'], 'required'],
            [['property', 'property_type', 'operation_type', 'rooms_in_the_apartment', 'material_housing', 'floor', 'floors_in_the_house', 'area', 'system_measure',
                'lease_term', 'price', 'price_period', 'necessary_furniture', 'internet', 'condition'], 'integer'],
            [['currency'], 'string']
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
            'necessary_furniture' => Yii::t('app', 'Necessary Furniture'),
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
    public function getnecessary_furniture0()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'necessary_furniture']);
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return Yii::$app->user->identity;
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
    public function getRealEstatePropertyTypeList()
    {
        switch ($this->property) {
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

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstateOperationTypeList()
    {
        switch ($this->property) {
            case 1:
                $property_operations = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => $this->property])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($property_operations as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 2:
                $property_operations = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => $this->property])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($property_operations as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 3:
                $property_operations = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => $this->property])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($property_operations as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 4:
                $property_operations = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => $this->property])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($property_operations as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 5:
                $property_operations = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => $this->property])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($property_operations as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 6:
                $property_operations = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => $this->property])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($property_operations as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 7:
                $property_operations = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => $this->property])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($property_operations as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
        }
        return false;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstateRoomsInApartmentList()
    {
        switch ($this->property) {
            case 1:
                $rooms_in_the_apartment = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 9])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($rooms_in_the_apartment as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 2:
                $rooms_in_the_apartment = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 15])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($rooms_in_the_apartment as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
        }
        return false;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstateMaterialHousingList()
    {
        $material_housing = ArrayHelper::map(AdRealEstateReference::find()
            ->where(['reference_id' => 24])
            ->all(), 'id', 'reference_name');
        $items = [];
        foreach($material_housing as $key => $value) {
            $items[$key] = Yii::t('references', $value);
        }
        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstateFloorsList()
    {
        $floor = ArrayHelper::map(AdRealEstateReference::find()
            ->where(['reference_id' => 11])
            ->all(), 'id', 'reference_name');
        $items = [];
        foreach($floor as $key => $value) {
            $items[$key] = Yii::t('references', $value);
        }
        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstateLeaseTermList()
    {
        $lease_term = ArrayHelper::map(AdRealEstateReference::find()
            ->where(['reference_id' => 13])
            ->all(), 'id', 'reference_name');
        $items = [];
        foreach($lease_term as $key => $value) {
            $items[$key] = Yii::t('references', $value);
        }
        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstatePricePeriodList()
    {
        $price_period = ArrayHelper::map(AdRealEstateReference::find()
            ->where(['reference_id' => 14])
            ->all(), 'id', 'reference_name');
        $items = [];
        foreach($price_period as $key => $value) {
            $items[$key] = Yii::t('references', $value);
        }
        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstateNecessaryFurnitureList()
    {
        $necessary_furniture = ArrayHelper::map(AdRealEstateReference::find()
            ->where(['reference_id' => 23])
            ->all(), 'id', 'reference_name');
        $items = [];
        foreach($necessary_furniture as $key => $value) {
            $items[$key] = Yii::t('references', $value);
        }
        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstateInternetList()
    {
        $internet = ArrayHelper::map(AdRealEstateReference::find()
            ->where(['reference_id' => 10])
            ->all(), 'id', 'reference_name');
        $items = [];
        foreach($internet as $key => $value) {
            $items[$key] = Yii::t('references', $value);
        }
        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstateConditionList()
    {
        $internet = ArrayHelper::map(AdRealEstateReference::find()
            ->where(['reference_id' => 25])
            ->all(), 'id', 'reference_name');
        $items = [];
        foreach($internet as $key => $value) {
            $items[$key] = Yii::t('references', $value);
        }
        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstateSystemMeasureName()
    {
        /* @var $user \common\models\User */
        $user = $this->getUser();
        $user->country->system_measure;

        switch ($user->country->system_measure) {
            case 0:
                /* @var $system_measure \common\models\AdRealEstateReference */
                $system_measure = AdRealEstateReference::find()
                    ->where(['id' => 75])
                    ->one();
                return Yii::t('references', $system_measure->reference_name);
            case 1:
                /* @var $system_measure \common\models\AdRealEstateReference */
                $system_measure = AdRealEstateReference::find()
                    ->where(['id' => 76])
                    ->one();
                return Yii::t('references', $system_measure->reference_name);
        }
        return false;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstateSystemMeasure()
    {
        /* @var $user \common\models\User */
        $user = $this->getUser();
        return $user->country->system_measure;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstateCurrency()
    {
        /* @var $user \common\models\User */
        $user = $this->getUser();
        return $user->country->currency;
    }
}
