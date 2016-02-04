<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "ad_real_estate".
 *
 * @property integer $id
 * @property integer $property
 * @property integer $type_of_property
 * @property integer $deal_type
 * @property integer $place_address_id
 * @property integer $rooms_in_the_apartment
 * @property integer $material_housing
 * @property integer $floor
 * @property integer $floors_in_the_house
 * @property integer $area_of_property
 * @property integer $measurement_of_property
 * @property integer $area_of_land
 * @property integer $measurement_of_land
 * @property integer $system_measure
 * @property integer $lease_term
 * @property integer $price
 * @property integer $price_for_the_period
 * @property integer $necessary_furniture
 * @property integer $internet
 * @property integer $pets_allowed
 * @property integer $condition
 *
 * @property AdCategory $adCategories
 * @property AdRealEstateReference $condition0
 * @property AdRealEstateReference $dealType
 * @property AdRealEstateReference $floor0
 * @property AdRealEstateReference $floorsInTheHouse
 * @property AdRealEstateReference $internet0
 * @property AdRealEstateReference $leaseTerm
 * @property AdRealEstateReference $materialHousing
 * @property AdRealEstateReference $measurementOfLand
 * @property AdRealEstateReference $measurementOfProperty
 * @property AdRealEstateReference $necessaryFurniture
 * @property AdRealEstateReference $petsAllowed
 * @property PlaceAddress $placeAddress
 * @property AdRealEstateReference $priceForThePeriod
 * @property AdRealEstateReference $typeOfProperty
 * @property AdRealEstateReference $roomsInTheApartment
 * @property AdRealEstateReference $typeOfProperty0
 * @property AdRealEstateAppliances[] $adRealEstateAppliances
 */

class AdRealEstate extends ActiveRecord
{
    public $currency;
    public $appliances;
    public $place_city;
    public $place_city_validate;
    public $place_street;
    public $place_house;
    public $place_address;

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
        $rules = array_merge(
            require(__DIR__ . '/rules/defaultRules.php'),
            require(__DIR__ . '/rules/realEstateRoomsRules.php'),                  // 1
            require(__DIR__ . '/rules/realEstateApartmentsRules.php'),             // 2
            require(__DIR__ . '/rules/realEstateHousesRules.php'),                 // 3
            require(__DIR__ . '/rules/realEstateLandRules.php'),                   // 4
            require(__DIR__ . '/rules/realEstateGaragesRules.php'),                // 5
            require(__DIR__ . '/rules/realEstateAbroadRules.php'),                 // 6
            require(__DIR__ . '/rules/realEstateCommercialRules.php')              // 7
        );
        return $rules;
    }

    public function validateFloor()
    {
        if($this->floor > $this->floors_in_the_house) {
            $this->addError('floors_in_the_house', Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floors_in_the_house')]));
        }
    }

    public function validateDealType()
    {

        $this->setErrorDealType('sellingRoom', 8);
        $this->setErrorDealType('rentARoom', 9);
        $this->setErrorDealType('buyRoom', 10);
        $this->setErrorDealType('rentingARoom', 11);
        $this->setErrorDealType('sellingApatrment', 12);
        $this->setErrorDealType('rentApatrment', 13);
        $this->setErrorDealType('buyApatrment', 14);
        $this->setErrorDealType('rentingApatrment', 15);
        $this->setErrorDealType('sellingHouse', 16);
        $this->setErrorDealType('rentHouse', 17);
        $this->setErrorDealType('buyHouse', 18);
        $this->setErrorDealType('rentingHouse', 19);
        $this->setErrorDealType('sellingLand', 20);
        $this->setErrorDealType('buyLand', 21);
        $this->setErrorDealType('sellingGarage', 22);
        $this->setErrorDealType('rentGarage', 23);
        $this->setErrorDealType('buyGarage', 24);
        $this->setErrorDealType('rentingGarage', 25);
        $this->setErrorDealType('sellingPropertyAbroad', 26);
        $this->setErrorDealType('buyPropertyAbroad', 27);
        $this->setErrorDealType('sellingComercial', 28);
        $this->setErrorDealType('rentComercial', 29);
        $this->setErrorDealType('buyComercial', 30);
        $this->setErrorDealType('rentingComercial', 31);
    }

    public function setErrorDealType($scenario, $dealType)
    {
        if ($this->scenario == $scenario && $this->deal_type != $dealType) {
            $this->addError('deal_type',
                Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]));
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'property' => Yii::t('app', 'Property'),
            'type_of_property' => Yii::t('app', 'Type Of Property'),
            'deal_type' => Yii::t('app', 'Deal Type'),
            'place_address_id' => Yii::t('app', 'Place Address ID'),
            'rooms_in_the_apartment' => Yii::t('app', 'Rooms In The Apartment'),
            'material_housing' => Yii::t('app', 'Material Housing'),
            'floor' => Yii::t('app', 'Floor'),
            'floors_in_the_house' => Yii::t('app', 'Floors In The House'),
            'area_of_property' => Yii::t('app', 'Area of property'),
            'area_of_land' => Yii::t('app', 'Area of land'),
            'measurement_of_property' => Yii::t('app', 'Measurement Of Property'),
            'lease_term' => Yii::t('app', 'Lease Term'),
            'price' => Yii::t('app', 'Price'),
            'price_for_the_period' => Yii::t('app', 'Price For The Period'),
            'necessary_furniture' => Yii::t('app', 'Necessary Furniture'),
            'internet' => Yii::t('app', 'Internet'),
            'pets_allowed' => Yii::t('app', 'Pets Allowed'),
            'condition' => Yii::t('app', 'Condition'),
            'appliances' => Yii::t('app', 'Appliances'),
            'place_city' => Yii::t('app', 'City'),
            'place_street' => Yii::t('app', 'Street Name'),
            'place_house' => Yii::t('app', 'House'),
            'place_address' => Yii::t('app', 'Address'),
            'measurement_of_land' => Yii::t('app', 'Measurement Of Land'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdCategories()
    {
        return $this->hasMany(AdCategory::className(), ['ad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCondition0()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'condition']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealType()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'deal_type']);
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
    public function getInternet0()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'internet']);
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
    public function getNecessaryFurniture()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'necessary_furniture']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPetsAllowed()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'pets_allowed']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceAddress()
    {
        return $this->hasOne(PlaceAddress::className(), ['id' => 'place_address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriceForThePeriod()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'price_for_the_period']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeOfProperty()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'type_of_property']);
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
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'measurement_of_property']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeOfProperty0()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'type_of_property']);
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
                $type_of_propertys = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 16])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($type_of_propertys as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 3:
                $type_of_propertys = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 17])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($type_of_propertys as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 4:
                $type_of_propertys = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 18])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($type_of_propertys as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 5:
                $type_of_propertys = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 19])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($type_of_propertys as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 6:
                $type_of_propertys = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 20])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($type_of_propertys as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 7:
                $type_of_propertys = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 21])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($type_of_propertys as $key => $value) {
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
    public function getRealEstateFloorsInBuildingList()
    {
        $floor = ArrayHelper::map(AdRealEstateReference::find()
            ->where(['reference_id' => 11])
            ->all(), 'id', 'reference_name');
        $items = [];
        $i = 1;
        foreach($floor as $key => $value) {
            if($i != 1)
                $items[$key] = Yii::t('references', $value);
            $i++;
        }
        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstateFloorsInHouseList()
    {
        $floor = ArrayHelper::map(AdRealEstateReference::find()
            ->where(['reference_id' => 9])
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
        $price_for_the_period = ArrayHelper::map(AdRealEstateReference::find()
            ->where(['reference_id' => 14])
            ->all(), 'id', 'reference_name');
        $items = [];
        foreach($price_for_the_period as $key => $value) {
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
    public function getRealEstateMeasurementOfPropertyName()
    {
        /* @var $user \common\models\User */
        $user = $this->getUser();
        $user->country->system_measure;

        switch ($user->country->system_measure) {
            case 0:
                /* @var $measurement_of_property \common\models\AdRealEstateReference */
                $measurement_of_property = AdRealEstateReference::find()
                    ->where(['id' => 75])
                    ->one();
                return Yii::t('references', $measurement_of_property->reference_name);
            case 1:
                /* @var $measurement_of_property \common\models\AdRealEstateReference */
                $measurement_of_property = AdRealEstateReference::find()
                    ->where(['id' => 76])
                    ->one();
                return Yii::t('references', $measurement_of_property->reference_name);
        }
        return false;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstateMeasurementOfLandName()
    {
        /* @var $user \common\models\User */
        $user = $this->getUser();
        $user->country->system_measure;

        switch ($user->country->system_measure) {
            case 0:
                /* @var $measurement_of_land \common\models\AdRealEstateReference */
                $measurement_of_land = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 28])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($measurement_of_land as $key => $value) {
                    $items[$key] = Yii::t('references', $value);
                }
                return $items;
            case 1:
                /* @var $measurement_of_land \common\models\AdRealEstateReference */
                $measurement_of_land = ArrayHelper::map(AdRealEstateReference::find()
                    ->where(['reference_id' => 29])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($measurement_of_land as $key => $value) {
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
    public function getRealEstatePetsAllowedList()
    {
        $material_housing = ArrayHelper::map(AdRealEstateReference::find()
            ->where(['reference_id' => 27])
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
    public function getRealEstateSystemMeasure()
    {
        /* @var $user \common\models\User */
        $user = $this->getUser();
        return $user->country->measurement_of_property;
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

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstatePriceForThePeriod($value)
    {
        /* @var $user \common\models\User */
        /* @var $value string */
        //dd($this->lease_term);
        //$user = $this->getUser();
        return $value;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getRealEstateAppliancesList()
    {
        $appliances = ArrayHelper::map(AdRealEstateReference::find()
            ->where(['reference_id' => 26])
            ->all(), 'id', 'reference_name');
        $items = [];
        foreach($appliances as $key => $value) {
            $items[$key] = Yii::t('references', $value);
        }
        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     *
     */
    public function addNewScenario($dealType, $property, $scenario)
    {
        $modelAdRealEstate = new AdRealEstate(['scenario' => $scenario]);
        $modelAdRealEstate->property = $property;
        $modelAdRealEstate->deal_type = $dealType;
        $modelAdRealEstate->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');
        return $modelAdRealEstate;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     *
     */
    public function checkForm($scenario, $modelAdRealEstate)
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        $modelAdRealEstate->scenario = $scenario;
        /* Проверям заполненные поля для полученного сценария */
        if($modelAdRealEstate->validate()) {
            /** Если используются сценарии, для которых необходимо получить адрес, находим этот адрес и пишем его в БД.
             *  Возвращется объект адреса из таблицы place_address с найденным place_id из Google Maps.
             *  Если адрес не найден, возвращается false
            */
            if($scenario == 'sellingRoom' || $scenario == 'rentARoom'
                || $scenario == 'sellingApatrment' || $scenario == 'rentApatrment'
                || $scenario == 'sellingHouse' || $scenario == 'rentHouse'
                || $scenario == 'sellingComercial' || $scenario == 'rentComercial') {

                /** Если валидация всех (кроме адреса и города) полей прошла успешно
                 *  формируем введенный адрес, где
                 *  $city - введенный город
                 *  $address - введеный адрес (улица и номер мода)
                 */
                $city = $modelAdRealEstate->place_city;
                $address = $modelAdRealEstate->place_house.', '.$modelAdRealEstate->place_street.', '.$modelAdRealEstate->place_city;
                /** Находим в Google Maps введенный адрес, если адрес найден и записан в БД,
                 *  возвращаем объект адреса из таблицы place_address. Если адрес не найден, вернется false.
                 */
                $placeAddress = Yii::$app->placeManager->findAddress($city, $address);

                if(!$placeAddress) {
                    $modelAdRealEstate->place_street = '';
                    $modelAdRealEstate->place_house = '';
                    $modelAdRealEstate->place_address = 0;
                }
                if($modelAdRealEstate->validate(['place_address'])) {
                    return $modelAdRealEstate;
                }
            } else {
                /** Если используются сценарии, для которых необходимо получить город, находим этот город и пишем его в БД.
                 *  Возвращется объект города из таблицы place_city с найденным place_id из Google Maps.
                 *  Если город не найден, возвращается false
                 */
                $placeCity = Yii::$app->placeManager->findCity($modelAdRealEstate->place_city);

                if(!$placeCity) {
                    $modelAdRealEstate->place_city_validate = 0;
                }
                if($modelAdRealEstate->validate(['place_city_validate'])) {
                    return $modelAdRealEstate;
                }
            }
        }
        return $modelAdRealEstate;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function createObject()
    {
        $modelAdRealEstate = new AdRealEstate();
        $modelAdRealEstate->property = $this->property;
        $modelAdRealEstate->deal_type = $this->deal_type;
        $modelAdRealEstate->save();
        dd($modelAdRealEstate);
        Yii::$app->session->set('tempModel', 'AdRealEstate');
        Yii::$app->session->set('tempId', $modelAdRealEstate->id);
        return  $modelAdRealEstate ? $modelAdRealEstate : null;
    }
    /**
     * @return \yii\db\ActiveQuery
     * @var $modelAdRealEstate \common\models\AdRealEstate
     */
    public function updateObject($modelAdRealEstate)
    {
        dd(222);
        $modelAdRealEstate->temp = 0;
        //$modelAdRealEstate->setScenario('update');
        if($modelAdRealEstate->save()):
            Yii::$app->session->remove('tempModel');
            Yii::$app->session->remove('tempId');
            return true;
        endif;
        return false;
    }

    /**
     * @param $modelAdRealEstate
     * @return \yii\db\ActiveQuery
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function deleteObject($modelAdRealEstate)
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        /* @var $one \common\models\ImagesOfObject */
        $modelImages = $modelAdRealEstate->imagesOfObjects;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach($modelImages as $one):
                $this->deleteImageFile($one->image->path);
                $this->deleteImageFile($one->image->path_small_image);
                $one->delete();
                $one->image->delete();
            endforeach;
            if($modelAdRealEstate->delete()):
                $transaction->commit();
            endif;
        } catch (Exception $e) {
            $transaction->rollBack();
        }
    }
    public function deleteImageFile($image_file) {
        if (empty('images/'.$image_file) || !file_exists('images/'.$image_file))
            return false;
        if (!unlink('images/'.$image_file))
            return false;
        return true;
    }

}
