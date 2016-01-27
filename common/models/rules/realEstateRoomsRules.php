<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 27.01.2016
 * Time: 7:20
 */
return [
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
    ['place_address', 'required',
        'on' => [
            'sellingRoom',
            'rentARoom',
        ]],
    [['property', 'deal_type', 'rooms_in_the_apartment', 'material_housing', 'floor', 'price', 'area', 'floors_in_the_house', 'condition'], 'required', 'on' => 'sellingRoom'],
    [['property', 'deal_type', 'rooms_in_the_apartment', 'material_housing', 'floor', 'price', 'area', 'floors_in_the_house', 'lease_term',
        'price_for_the_period', 'necessary_furniture', 'internet', 'pets_allowed', 'condition'], 'required', 'on' => 'rentARoom'],
    [['property', 'deal_type', 'price'], 'required', 'on' => 'buyRoom'],
    [['property', 'deal_type', 'price', 'lease_term', 'price_for_the_period'], 'required', 'on' => 'rentingARoom'],
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
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('material_housing')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('material_housing')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('material_housing')])],
    [['floor', 'floors_in_the_house'], 'number', 'min' => 44, 'max' => 74,
        'on' => [
            'sellingRoom',
            'rentARoom',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')])],
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
    [['internet'], 'number', 'min' => 39, 'max' => 40,
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
    [['condition'], 'number', 'min' => 41, 'max' => 43,
        'on' => [
            'sellingRoom',
            'rentARoom',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')])],
    [['appliances'], 'number', 'min' => 118, 'max' => 124,
        'on' => [
            'rentARoom',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('appliances')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('appliances')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('appliances')])],
];