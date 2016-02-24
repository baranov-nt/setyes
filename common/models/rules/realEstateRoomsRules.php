<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 27.01.2016
 * Time: 7:20
 */
return [
    [
        ['property', 'deal_type', 'place_city', 'place_street', 'place_house', 'place_address', 'rooms_in_the_apartment', 'measurement_of_property', 'material_housing',
            'floor', 'floors_in_the_house', 'area_of_property', 'price', 'condition', 'model_scenario'], 'required',
        'on' => 'sellingRoom'
    ],
    [
        ['property', 'deal_type', 'place_city', 'place_street', 'place_house', 'place_address', 'rooms_in_the_apartment', 'measurement_of_property', 'material_housing', 'floor',
            'floors_in_the_house', 'area_of_property', 'lease_term', 'price', 'price_for_the_period', 'necessary_furniture', 'internet', 'pets_allowed', 'condition', 'model_scenario'], 'required',
        'on' => 'rentARoom'
    ],
    [
        ['property', 'deal_type', 'place_city', 'price', 'model_scenario'], 'required',
        'on' => 'buyRoom'
    ],
    [
        ['property', 'deal_type', 'place_city', 'lease_term', 'price', 'price_for_the_period', 'model_scenario'], 'required',
        'on' => 'rentingARoom'
    ],
    ['property', 'compare', 'compareValue' => 1, 'operator' => '==',
        'on' => [
            'rooms',
            'sellingRoom',
            'rentARoom',
            'buyRoom',
            'rentingARoom'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('property')])],  // значение недвижемости для сделок с комнатами
    ['deal_type', 'number', 'min' => 8, 'max' => 11,
        'on' => [
            'sellingRoom',
            'rentARoom',
            'buyRoom',
            'rentingARoom'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')])],
    ['rooms_in_the_apartment', 'number', 'min' => 32, 'max' => 38,
        'on' => [
            'sellingRoom',
            'rentARoom',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')])],
    ['material_housing', 'number', 'min' => 112, 'max' => 117,
        'on' => [
            'sellingRoom',
            'rentARoom',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')])],
    [['floor', 'floors_in_the_house'], 'number', 'min' => 43, 'max' => 74,
        'on' => [
            'sellingRoom',
            'rentARoom',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')])],
    [['floor', 'floors_in_the_house'], 'validateFloor',
        'on' => [
            'sellingRoom',
            'rentARoom',
        ],
    ],
    [['lease_term'], 'number', 'min' => 77, 'max' => 78,
        'on' => [
            'rentARoom',
            'rentingARoom'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')])],
    [['price_for_the_period'], 'number', 'min' => 79, 'max' => 80,
        'on' => [
            'rentARoom',
            'rentingARoom'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')])],
    [['necessary_furniture'], 'number', 'min' => 110, 'max' => 111,
        'on' => [
            'rentARoom',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('necessary_furniture')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('necessary_furniture')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('necessary_furniture')])],
    [['internet'], 'number', 'min' => 132, 'max' => 133,
        'on' => [
            'rentARoom',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('internet')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('internet')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('internet')])],
    [['pets_allowed'], 'number', 'min' => 125, 'max' => 126,
        'on' => [
            'rentARoom',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('pets_allowed')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('pets_allowed')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('pets_allowed')])],
    [['condition'], 'number', 'min' => 39, 'max' => 41,
        'on' => [
            'sellingRoom',
            'rentARoom',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')])],
    ['appliances', 'in', 'range' => [118, 119, 120, 121, 122, 123, 124], 'allowArray' => true,
        'on' => 'rentARoom'
    ],
    ['appliances', 'each', 'rule' => ['in', 'range' => [118, 119, 120, 121, 122, 123, 124]],
        'on' => 'rentARoom'],
];