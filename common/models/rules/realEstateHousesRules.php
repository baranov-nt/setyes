<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.01.2016
 * Time: 10:47
 */
return [
    [['type_of_property', 'property', 'deal_type', 'place_city', 'place_street', 'place_house', 'rooms_in_the_apartment', 'material_housing',
       'price', 'area', 'floors_in_the_house', 'condition'], 'required',
        'on' => 'sellingHouse'
    ],
    [['type_of_property', 'property', 'deal_type', 'place_city', 'place_street', 'place_house', 'rooms_in_the_apartment', 'material_housing',
        'price', 'area', 'floors_in_the_house', 'lease_term', 'price_for_the_period', 'necessary_furniture', 'internet', 'pets_allowed', 'condition'], 'required',
        'on' =>
            'rentHouse'
    ],
    ['property', 'compare', 'compareValue' => 3, 'operator' => '==',
        'on' => [
            'houses',
            'sellingHouse',
            'rentHouse',
            'buyHouse',
            'rentingHouse'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('property')])],
];