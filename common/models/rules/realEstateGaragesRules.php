<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.01.2016
 * Time: 10:48
 */
return [
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'place_street', 'material_housing', 'area_of_property', 'price', 'condition'], 'required',
        'on' => 'sellingGarage'
    ],
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'place_street', 'material_housing', 'area_of_property', 'lease_term', 'price',
            'price_for_the_period', 'condition'], 'required',
        'on' => 'rentGarage'
    ],
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'place_street'], 'required',
        'on' => 'buyGarage'
    ],
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'place_street', 'lease_term'], 'required',
        'on' => 'rentingGarage'
    ],
    ['property', 'compare', 'compareValue' => 5, 'operator' => '==',
        'on' => [
            'garages',
            'sellingGarage',
            'rentGarage',
            'buyGarage',
            'rentingGarage'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('property')])],  // значение недвижемости для сделок с комнатами
    ['deal_type', 'number', 'min' => 22, 'max' => 25,
        'on' => [
            'sellingGarage',
            'rentGarage',
            'buyGarage',
            'rentingGarage'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')])],
    ['type_of_property', 'number', 'min' => 98, 'max' => 99,
        'on' => [
            'sellingGarage',
            'rentGarage',
            'buyGarage',
            'rentingGarage'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')])],
    ['material_housing', 'number', 'min' => 112, 'max' => 117,
        'on' => [
            'sellingGarage',
            'rentGarage',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')])],
    [['lease_term'], 'number', 'min' => 77, 'max' => 78,
        'on' => [
            'rentGarage',
            'rentingGarage'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')])],
    [['price_for_the_period'], 'number', 'min' => 79, 'max' => 80,
        'on' => [
            'rentGarage',
            'rentingGarage'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')])],
    [['condition'], 'number', 'min' => 39, 'max' => 41,
        'on' => [
            'sellingGarage',
            'rentGarage',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')])
    ],
];