<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 27.01.2016
 * Time: 21:55
 */
return [
    ['deal_type', 'validateDealType', 'on' => [
        /* комнаты 1 */
        'rooms',
        'sellingRoom',
        'rentARoom',
        'buyRoom',
        'rentingARoom',
        /* квартиры 2 */
        'apartments',
        'sellingApatrment',
        'rentApatrment',
        'buyApatrment',
        'rentingApatrment',
        /* дома 3 */
        'houses',
        'sellingHouse',
        'rentHouse',
        'buyHouse',
        'rentingHouse',
        /* земля 4 */
        'land',
        'sellingLand',
        'buyLand',
        /* гаражи 5 */
        'garages',
        'sellingGarage',
        'rentGarage',
        'buyGarage',
        'rentingGarage',
        /* недвижемость за рубежем 6 */
        'propertyAbroad',
        'sellingPropertyAbroad',
        'buyPropertyAbroad',
        /* коммерческая недвижемость */
        'comercial',
        'sellingComercial',
        'rentComercial',
        'buyComercial',
        'rentingComercial'
    ]],
    [['property', 'type_of_property', 'deal_type', 'rooms_in_the_apartment', 'material_housing', 'floor', 'floors_in_the_house', 'area_of_property', 'area_of_land',
        'measurement_of_property', 'lease_term', 'price_for_the_period', 'necessary_furniture', 'internet', 'pets_allowed', 'condition'], 'integer'],
    ['material_housing', 'number', 'min' => 112, 'max' => 117,
        'on' => [
            'sellingRoom',
            'rentARoom',
            'sellingApatrment',
            'rentAApatrment',
            'sellingHouse',
            'rentHouse',
            'sellingGarage',
            'rentGarage',
            'sellingPropertyAbroad',
            'sellingComercial',
            'rentComercial',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('material_housing')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('material_housing')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('material_housing')])],
    [['floor', 'floors_in_the_house'], 'number', 'min' => 44, 'max' => 74,
        'on' => [
            'sellingRoom',
            'rentARoom',
            'sellingApatrment',
            'rentAApatrment',
            'sellingComercial',
            'rentComercial',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')])],
    [['floor', 'floors_in_the_house'], 'validateFloor',
        'on' => [
            'sellingRoom',
            'rentARoom',
            'sellingApatrment',
            'rentAApatrment',
            'sellingComercial',
            'rentComercial',
        ],
    ],
    ['floors_in_the_house', 'number', 'min' => 32, 'max' => 38,
        'on' => [
            'sellingHouse',
            'rentHouse',
            'sellingPropertyAbroad',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')])],
    ['area_of_property', 'required',
        'on' => [
            'sellingRoom',
            'rentARoom',
            'sellingApatrment',
            'rentAApatrment',
            'sellingHouse',
            'rentHouse',
            'sellingGarage',
            'rentGarage',
            'sellingPropertyAbroad',
            'sellingComercial',
            'rentComercial',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('area_of_property')])],
    ['area_of_land', 'required',
        'on' => [
            'sellingLand',
            'sellingHouse',
            'rentHouse'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('area_of_land')])],
    ['price', 'double'],
    ['price', 'compare', 'compareValue' => '0.00', 'operator' => '!=',
        'on' => [
            /* комнаты 1 */
            'sellingRoom',
            'rentARoom',
            'buyRoom',
            'rentingARoom',
            /* квартиры 2 */
            'sellingApatrment',
            'rentApatrment',
            'buyApatrment',
            'rentingApatrment',
            /* дома 3 */
            'houses',
            'sellingHouse',
            'rentHouse',
            'buyHouse',
            'rentingHouse',
            /* земля 4 */
            'land',
            'sellingLand',
            'buyLand',
            /* гаражи 5 */
            'garages',
            'sellingGarage',
            'rentGarage',
            'buyGarage',
            'rentingGarage',
            /* недвижемость за рубежем 6 */
            'propertyAbroad',
            'sellingPropertyAbroad',
            'buyPropertyAbroad',
            /* коммерческая недвижемость */
            'comercial',
            'sellingComercial',
            'rentComercial',
            'buyComercial',
            'rentingComercial'
        ],
        'message' => Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $this->getAttributeLabel('price')])],  // цены

    [['place_address'], 'compare', 'compareValue' => 1, 'operator' => '==',
        'on' => [
            'sellingRoom',
            'rentARoom',
            'sellingApatrment',
            'rentApatrment',
            'sellingHouse',
            'rentHouse',
            'sellingComercial',
            'rentComercial',
        ],
        'message' => Yii::t('app', 'Unfortunately, the specified address was not found.')],
    [['place_city_validate'], 'compare', 'compareValue' => 1, 'operator' => '==',
        'message' => Yii::t('app', 'Unfortunately, the specified city was not found.')],
    [['place_street', 'place_house'], 'required',
        'on' => [
            'sellingRoom',
            'rentARoom',
            'sellingApatrment',
            'rentApatrment',
            'sellingHouse',
            'rentHouse',
            'sellingComercial',
            'rentComercial',
        ]],
    [['currency', 'scenario', 'place_city', 'place_street', 'place_house', 'place_address'], 'string'],
];