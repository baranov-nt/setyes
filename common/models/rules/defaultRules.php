<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 27.01.2016
 * Time: 21:55
 */
return [
    [['place_city', 'deal_type'], 'required'],
    ['deal_type', 'validateDealType', 'on' => [
        /* комнаты 1 */
        'sellingRoom',
        'rentARoom',
        'buyRoom',
        'rentingARoom',
        /* квартиры 2 */
        'sellingApatrment',
        'rentAApatrment',
        'buyApatrment',
        'rentingAApatrment',
        /* дома 3 */
        'houses',
        'sellingHouse',
        'rentHouse',
        'buyHouse',
        'rentingHouse',
        /* земля 4 */
        'land',
        'sellingHouse',
        'buyHouse',
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
    [['property', 'type_of_property', 'deal_type', 'rooms_in_the_apartment', 'material_housing', 'floor', 'floors_in_the_house', 'area',
        'system_measure', 'lease_term', 'price_for_the_period', 'necessary_furniture', 'internet', 'pets_allowed', 'condition'], 'integer'],
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
            'rentAApatrment',
            'buyApatrment',
            'rentingAApatrment',
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
    [['floor', 'floors_in_the_house'], 'validateFloor',
        'on' => [
            'sellingRoom',
            'rentARoom',
            'sellingApatrment',
            'rentAApatrment',
        ],
    ],
    [['currency', 'scenario', 'place_city', 'place_street', 'place_house'], 'string'],
];