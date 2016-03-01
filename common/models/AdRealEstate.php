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
 * @property integer $deal_type
 * @property integer $type_of_property
 * @property integer $place_address_id
 * @property integer $rooms_in_the_apartment
 * @property integer $material_housing
 * @property integer $floor
 * @property integer $floors_in_the_house
 * @property integer $area_of_property
 * @property integer $measurement_of_property
 * @property integer $area_of_land
 * @property integer $measurement_of_land
 * @property integer $lease_term
 * @property integer $price
 * @property integer $price_for_the_period
 * @property integer $necessary_furniture
 * @property integer $internet
 * @property integer $pets_allowed
 * @property integer $condition
 * @property integer $images_label
 * @property string $model_scenario
 * @property integer $temp
 * @property integer $model_is
 *
 * @property AdRealEstate[] $columnList
 * @property AdRealEstate[] $contentList
 * @property AdCategory $adCategory
 * @property AdRealEstateReference $condition0
 * @property ImagesOfObject $imagesOfObjects
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
 * @property AdRealEstateReference $property0
 * @property AdRealEstateReference $roomsInTheApartment
 * @property AdRealEstateReference $typeOfProperty
 * @property AdRealEstateAppliances[] $adRealEstateAppliances
 */

class AdRealEstate extends ActiveRecord
{
    public $currency;
    public $appliances;
    public $place_city;
    public $place_city_id;
    public $place_city_validate;
    public $place_street;
    public $place_street_validate;
    public $place_house;
    public $place_address;
    public $style;
    public $phone_temp_ad;
    public $link_temp_ad;
    public $model_is;

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

    public function validateAreaOfLand()
    {
        if($this->area_of_land) {
            if(!$this->measurement_of_land) {
                $this->addError('measurement_of_land', Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $this->getAttributeLabel('measurement_of_land')]));
            }
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
            'deal_type' => Yii::t('app', 'Deal Type'),
            'type_of_property' => Yii::t('app', 'Type Of Property'),
            'place_address_id' => Yii::t('app', 'Place Address ID'),
            'rooms_in_the_apartment' => Yii::t('app', 'Rooms In The Apartment'),
            'material_housing' => Yii::t('app', 'Material Housing'),
            'floor' => Yii::t('app', 'Floor'),
            'floors_in_the_house' => Yii::t('app', 'Floors In The House'),
            'area_of_property' => Yii::t('app', 'Area of property'),
            'measurement_of_property' => Yii::t('app', 'Measurement Of Property'),
            'area_of_land' => Yii::t('app', 'Area of land'),
            'measurement_of_land' => Yii::t('app', 'Measurement Of Land'),
            'lease_term' => Yii::t('app', 'Lease Term'),
            'price' => Yii::t('app', 'Price'),
            'price_for_the_period' => Yii::t('app', 'Price For The Period'),
            'necessary_furniture' => Yii::t('app', 'Necessary Furniture'),
            'internet' => Yii::t('app', 'Internet'),
            'pets_allowed' => Yii::t('app', 'Pets Allowed'),
            'condition' => Yii::t('app', 'Condition'),
            'images_label' => Yii::t('app', 'Images Label'),
            'appliances' => Yii::t('app', 'Appliances'),
            'place_city' => Yii::t('app', 'City'),
            'place_street' => Yii::t('app', 'Street Name'),
            'place_house' => Yii::t('app', 'House'),
            'place_address' => Yii::t('app', 'Address'),
            'temp' => Yii::t('app', 'Temp'),
            'style' => Yii::t('app', 'Style'),
            'phone_temp_ad' => Yii::t('app', 'Phone for temp ad'),
            'link_temp_ad' => Yii::t('app', 'Link from temp ad'),
            'model_is' => Yii::t('app', 'model_is'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagesOfObjects()
    {
        return $this->hasMany(ImagesOfObject::className(),
            [
                'object_id' => 'id',
                'label' => 'images_label'
            ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdCategory()
    {
        return $this->hasOne(AdCategory::className(), ['ad_id' => 'id']);
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
    public function getMeasurementOfLand()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'measurement_of_land']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeasurementOfProperty()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'measurement_of_property']);
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
    public function getProperty0()
    {
        return $this->hasOne(AdRealEstateReference::className(), ['id' => 'property']);
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
    public function getTypeOfProperty()
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

    public function getAddress($modelAdRealEstate) {
        if ($modelAdRealEstate->placeAddress) {
            /* Получает строку адреса */
            return Yii::$app->placeManager->getAddress($modelAdRealEstate);
        } else {
            /* Получает строку города */
            return Yii::$app->placeManager->getCity($modelAdRealEstate);
        }
    }

    public function getCity($modelAdRealEstate) {
        return Yii::$app->placeManager->getCity($modelAdRealEstate);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubDir()
    {
        $count = \common\models\AdCategory::find()
            ->where(['category' => 1])
            ->groupBy('ad_id')
            ->count();
        $count = floor($count/1000);
        return $count;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumnList()
    {
        $items = [
            [
                'attribute' => 'property',
                'value' => Yii::t('references', $this->property0->reference_name),
            ],
            [
                'attribute' => 'deal_type',
                'value' => Yii::t('references', $this->dealType->reference_name),
            ],
            [
                'attribute' => 'place_city',
                'value' => $this->place_city,
            ],
        ];
        if($this->place_street)
            $items[] = [
                'attribute' => 'place_address',
                'value' => $this->place_street.', '.$this->place_house,
            ];
        if($this->type_of_property)
            $items[] = [
                'attribute' => 'type_of_property',
                'value' => Yii::t('references', $this->typeOfProperty->reference_name),
            ];
        if($this->area_of_property)
            $items[] = [
                'attribute' => 'area_of_property',
                'value' => $this->area_of_property.' '.Yii::t('references', $this->measurementOfProperty->reference_name),
            ];
        if($this->area_of_land) {
            $items[] = [
                'attribute' => 'area_of_land',
                'value' => $this->area_of_land . ' ' . Yii::t('references', $this->measurementOfLand->reference_name),
            ];
        }
        if($this->rooms_in_the_apartment)
            $items[] = [
                'attribute' => 'rooms_in_the_apartment',
                'value' => Yii::t('references', $this->roomsInTheApartment->reference_name),
            ];
        if($this->material_housing)
            $items[] = [
                'attribute' => 'material_housing',
                'value' => Yii::t('references', $this->materialHousing->reference_name),
            ];
        if($this->floor)
            $items[] = [
                'attribute' => 'floor',
                'value' => Yii::t('references', $this->floor0->reference_name),
            ];
        if($this->floors_in_the_house)
            $items[] = [
                'attribute' => 'floors_in_the_house',
                'value' => Yii::t('references', $this->floorsInTheHouse->reference_name),
            ];
        if($this->lease_term)
            $items[] = [
                'attribute' => 'lease_term',
                'value' => Yii::t('references', $this->leaseTerm->reference_name),
            ];
        if($this->price)
            $items[] = [
                'attribute' => 'price',
                'value' => Yii::$app->formatter->asCurrency(Yii::t('references', $this->price), $this->user->country->currency),
            ];
        if($this->price_for_the_period)
            $items[] = [
                'attribute' => 'price_for_the_period',
                'value' => Yii::t('references', $this->priceForThePeriod->reference_name),
            ];
        if($this->necessary_furniture)
            $items[] = [
                'attribute' => 'necessary_furniture',
                'value' => Yii::t('references', $this->necessaryFurniture->reference_name),
            ];
        if($this->internet)
            $items[] = [
                'attribute' => 'internet',
                'value' => Yii::t('references', $this->internet0->reference_name),
            ];
        if($this->pets_allowed)
            $items[] = [
                'attribute' => 'pets_allowed',
                'value' => Yii::t('references', $this->petsAllowed->reference_name),
            ];
        if($this->condition)
            $items[] = [
                'attribute' => 'condition',
                'value' => Yii::t('references', $this->condition0->reference_name),
            ];
        if($this->adRealEstateAppliances) {
            $itemsDiv = '';
            $items_appliance = '';
            foreach ($this->adRealEstateAppliances as $one) {
                $items_appliance .= $itemsDiv . Yii::t('references', $one->reference->reference_name);
                $itemsDiv = ', ';
            }
            $items[] = [
                'attribute' => 'appliances',
                'value' => $items_appliance,
            ];
        }
        if($this->adCategory->adMain->phone_temp_ad)
            $items[] = [
                'attribute' => 'phone_temp_ad',
                'value' => $this->adCategory->adMain->phone_temp_ad,
            ];
        return $items;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentList()
    {
        $modelAdRealEstate = new AdRealEstate();
        $items = '';
        if($this->type_of_property)
            $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('type_of_property').':</strong> '.Yii::t('references', $this->typeOfProperty->reference_name).'</p>';
        if($this->area_of_property)
            $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('area_of_property').':</strong> '.Yii::t('references', $this->area_of_property).' '.Yii::t('references', $this->measurementOfProperty->reference_name).'</p>';
        if($this->area_of_land)
            $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('area_of_land').':</strong> '.Yii::t('references', $this->area_of_land).' '.Yii::t('references', $this->measurementOfLand->reference_name).'</p>';
        if($this->rooms_in_the_apartment)
            $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('rooms_in_the_apartment').':</strong> '.Yii::t('references', $this->roomsInTheApartment->reference_name).'</p>';
        if($this->material_housing)
            $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('material_housing').':</strong> '.Yii::t('references', $this->materialHousing->reference_name).'</p>';
        if($this->floor)
            $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('floor').':</strong> '.Yii::t('references', $this->floor0->reference_name).'</p>';
        if($this->floors_in_the_house)
            $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('floors_in_the_house').':</strong> '.Yii::t('references', $this->floorsInTheHouse->reference_name).'</p>';
        if($this->lease_term)
            $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('lease_term').':</strong> '.Yii::t('references', $this->leaseTerm->reference_name).'</p>';
        if($this->price)
            $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('price').':</strong> '.
                Yii::$app->formatter->asCurrency(Yii::t('references', $this->price), $this->user->country->currency)
                .'</p>';
        if($this->price_for_the_period)
            $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('price_for_the_period').':</strong> '.Yii::t('references', $this->priceForThePeriod->reference_name).'</p>';
        if($this->necessary_furniture)
            $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('necessary_furniture').':</strong> '.Yii::t('references', $this->necessaryFurniture->reference_name).'</p>';
        if($this->internet)
            $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('internet').':</strong> '.Yii::t('references', $this->internet0->reference_name).'</p>';
        if($this->pets_allowed)
            $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('pets_allowed').':</strong> '.Yii::t('references', $this->petsAllowed->reference_name).'</p>';
        if($this->adRealEstateAppliances) {
            $itemsDiv = '';
            $items .= '<p class="content-elem"><strong>' . $modelAdRealEstate->getAttributeLabel('appliances') . ':</strong> ';
            foreach ($this->adRealEstateAppliances as $one) {
                $items .= $itemsDiv . Yii::t('references', $one->reference->reference_name);
                $itemsDiv = ', ';
            }
        }
        if($this->condition)
            $items .= '<p class="content-elem"><strong>'.$modelAdRealEstate->getAttributeLabel('condition').':</strong> '.Yii::t('references', $this->condition0->reference_name).'</p>';
        return $items;
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
        $condition = ArrayHelper::map(AdRealEstateReference::find()
            ->where(['reference_id' => 25])
            ->all(), 'id', 'reference_name');
        $items = [];
        foreach($condition as $key => $value) {
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
    public function getRealEstateMeasurementOfPropertyId()
    {
        /* @var $user \common\models\User */
        $user = $this->getUser();
        $user->country->system_measure;

        switch ($user->country->system_measure) {
            case 0:
                /* @var $measurement_of_property \common\models\AdRealEstateReference */
                return 75;
            case 1:
                /* @var $measurement_of_property \common\models\AdRealEstateReference */
                return 76;
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
     */
    public function getRealEstateAppliancesListChecked($modelAdRealEstate)
    {
        /* @var $modelAdRealEstate AdRealEstate */
        $items = [];
        foreach($modelAdRealEstate->adRealEstateAppliances as $one) {
            $items[] = $one->reference_id;
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

    public function getAttributesArray($attributes)
    {

        unset(
            $attributes['id'],
            $attributes['area_of_property'],
            $attributes['area_of_land'],
            $attributes['price'],
            $attributes['images_label']
        );

        /* Ищем повтор только у опубликованных объявлений */
        $attributes['temp'] = 0;

        return $attributes;
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
        $modelAdRealEstate->setScenario($scenario);

        if(isset(Yii::$app->request->post('AdRealEstate')['appliances'])) {
            $modelAdRealEstate->appliances = Yii::$app->request->post('AdRealEstate')['appliances'];
        }

        /* Проверям заполненные поля для полученного сценария */
        if ($modelAdRealEstate->validate()) {
            /* Находит введенный город */
            $modelAdRealEstate = $this->findCity($modelAdRealEstate);
            /* Находит введенную улицу, если город найден */
            if(!$modelAdRealEstate->errors) {
                /* Сценарии для поиска улицы, с номером дома */
                if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
                    || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
                    || $modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse'
                ) {
                    if($this->place_street != '' || $this->place_house != '') {
                        $modelAdRealEstate = $this->findAddress($modelAdRealEstate);
                    } else {
                        $modelAdRealEstate->place_address_id = '';
                    }
                }
            }

            if(!$modelAdRealEstate->errors) {
                /* Для определенных сценариев проверяем объявления на дублирование  */
                if($modelAdRealEstate->scenario == 'buyRoom' || $modelAdRealEstate->scenario == 'rentingARoom'
                    || $modelAdRealEstate->scenario == 'buyApatrment' || $modelAdRealEstate->scenario == 'rentingApatrment'
                    || $modelAdRealEstate->scenario == 'buyHouse' || $modelAdRealEstate->scenario == 'rentingHouse'
                    || $modelAdRealEstate->scenario == 'buyLand'
                ) {
                    $modelAdRealEstateIs = AdRealEstate::find()
                        ->where($this->getAttributesArray($modelAdRealEstate->attributes))
                        ->joinWith([
                            'adCategory.adMain' => function ($query) {
                                $query->andWhere(['user_id' => Yii::$app->user->id]);
                                $query->andWhere(['phone_temp_ad' => $this->phone_temp_ad]);
                                $query->andWhere(['place_city_id' => $this->place_city_id]);
                            },
                        ])
                        //->where(['place_address' => $modelAdRealEstate->place_address])
                        ->one();
                    if($modelAdRealEstateIs) {
                        // Если такаяже запись найдена, направляем на ее редактирование
                        $modelAdRealEstateIs->addError('model_is');
                        return $modelAdRealEstateIs;
                    }
                }
                $modelAdRealEstate = $this->saveAd($modelAdRealEstate);
            }
        }
        return $modelAdRealEstate;
    }

    /**
     * @param $modelAdRealEstate
     * @return AdRealEstate
     * @throws Exception
     */
    public function saveAd($modelAdRealEstate) {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        //$modelAdRealEstate->temp = 1;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($modelAdRealEstate->save()) {
                if(isset(Yii::$app->request->post('AdRealEstate')['appliances'])) {
                    $modelAdRealEstate->appliances = Yii::$app->request->post('AdRealEstate')['appliances'];

                    AdRealEstateAppliances::deleteAll(['real_estate_id' => $modelAdRealEstate->id]);
                    foreach ($modelAdRealEstate->appliances as $one) {
                        $modelAdRealEstateAppliances = new AdRealEstateAppliances();
                        $modelAdRealEstateAppliances->real_estate_id = $modelAdRealEstate->id;
                        $modelAdRealEstateAppliances->reference_id = $one;
                        $modelAdRealEstateAppliances->save();
                    }
                }
                $modelCategory = $modelAdRealEstate->adCategory ? ($modelCategory = AdCategory::findOne($modelAdRealEstate->adCategory->id)) : new AdCategory();
                $modelCategory->category = 1;                       // Категория для недвижемость 1 (из reference main)
                $modelCategory->ad_id = $modelAdRealEstate->id;
                if($modelCategory->save()) {
                    $modelAdMain = ($modelAdMain = AdMain::findOne(['category_id' => $modelCategory->id])) ? $modelAdMain : new AdMain();
                    $modelAdMain->user_id = Yii::$app->user->id;
                    $modelAdMain->place_city_id = $this->place_city_id;
                    $modelAdMain->category_id = $modelCategory->id;
                    $modelAdMain->phone_temp_ad = $this->phone_temp_ad;
                    $modelAdMain->link_temp_ad = $this->link_temp_ad;
                    //$modelAdMain->ad_style_id = 1;
                    if($modelAdMain->save()) {
                        $transaction->commit();
                    }
                }
            } else {
                \Yii::$app->session->set('error', 'Объявление недвижимости не добавлено.');         // если все в порядке, пишем в сессию путь к изображениею
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
        return  $modelAdRealEstate;
    }

    public function compliteAd($modelAdRealEstate) {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */

        $modelAdRealEstate->temp = 1;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($modelAdRealEstate->save()) {
                $modelCategory = new AdCategory();
                $modelCategory->category = $modelAdRealEstate->property;                       // Категория для недвижемость 1
                $modelCategory->ad_id = $modelAdRealEstate->id;
                if($modelCategory->save()) {
                    $modelAdMain = new AdMain();
                    $modelAdMain->user_id = Yii::$app->user->id;
                    $modelAdMain->place_city_id = $this->place_city_id;
                    $modelAdMain->category_id = $modelCategory->id;
                    $modelAdMain->phone_temp_ad = $this->phone_temp_ad;
                    //$modelAdMain->ad_style_id = 1;
                    if($modelAdMain->save()) {
                        $transaction->commit();
                    }
                }
            } else {
                \Yii::$app->session->set('error', 'Объявление недвижимости не добавлено.');         // если все в порядке, пишем в сессию путь к изображениею
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
        return  $modelAdRealEstate;
    }

    /* Функция для нахождения города по введенному значению */
    private function findCity($modelAdRealEstate) {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        /* @var $modelPlaceCity \common\models\PlaceCity */
        $modelPlaceCity = Yii::$app->placeManager->findCity($modelAdRealEstate->place_city);

        if (!$modelPlaceCity) {
            $modelAdRealEstate->place_city = '';
            $modelAdRealEstate->place_city_validate = 0;
        }
        if ($modelAdRealEstate->validate(['place_city_validate'])) {
            $this->place_city_id = $modelPlaceCity->id;
        }
        return $modelAdRealEstate;
    }

    /* Функция для нахождения улицы по введенному значению */
    private function findAddress($modelAdRealEstate) {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        /* @var $placeStreet \common\models\PlaceAddress */
        $city = $modelAdRealEstate->place_city;
        $street = $modelAdRealEstate->place_house.', '.$modelAdRealEstate->place_street . ', ' . $modelAdRealEstate->place_city;
        $placeStreet = Yii::$app->placeManager->findStreet($city, $street);

        if (!$placeStreet) {
            /* Если адрес не найден устанавливаем place_address = 0, вывод ошибки ввода адреса */
            $modelAdRealEstate->place_street = '';
            $modelAdRealEstate->place_address = 0;
        }
        if ($modelAdRealEstate->validate(['place_address'])) {
            $this->place_city_id = $placeStreet->city->id;
            $modelAdRealEstate->place_address_id = $placeStreet->id;
        }

        return $modelAdRealEstate;
    }

    /**
     * @param $modelProduct
     * @return \yii\db\ActiveQuery
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function deleteObject($modelAdRealEstate)
    {
        /* @var $modelAdRealEstate \common\models\AdRealEstate */
        /* @var $one \common\models\ImagesOfObject */
        if($modelAdRealEstate->temp == 1) {
            $modelImages = $modelAdRealEstate->imagesOfObjects;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach($modelImages as $one) {
                    $this->deleteImageFile($one->image->path);
                    $this->deleteImageFile($one->image->path_small_image);
                    $one->delete();
                    $one->image->delete();
                }

                if($modelAdRealEstate->adCategory->adMain->delete()) {
                    if($modelAdRealEstate->adCategory->delete()) {
                        if($modelAdRealEstate->delete()) {
                            $transaction->commit();
                        }
                    }
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
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
