<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 27.01.2016
 * Time: 21:55
 */
return [
    ['deal_type', 'validateDealType', 'on' => [
        'sellingRoom',
        'rentARoom',
        'buyRoom',
        'rentingARoom',
        'sellingApatrment',
        'rentAApatrment',
        'buyApatrment',
        'rentingAApatrment'
    ]],
    [['property', 'type_of_property', 'deal_type', 'rooms_in_the_apartment', 'material_housing', 'floor', 'floors_in_the_house', 'area',
        'system_measure', 'lease_term', 'price_for_the_period', 'necessary_furniture', 'internet', 'pets_allowed', 'condition'], 'integer'],
    ['price', 'double'],
    ['price', 'compare', 'compareValue' => '0.00', 'operator' => '!=',
        'on' => [
            'sellingRoom',
            'rentARoom',
            'buyRoom',
            'rentingARoom',
            'sellingApatrment',
            'rentAApatrment',
            'buyApatrment',
            'rentingAApatrment'
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