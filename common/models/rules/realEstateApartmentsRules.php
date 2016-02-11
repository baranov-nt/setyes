<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 27.01.2016
 * Time: 19:44
 */
return [
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'place_street', 'place_house', 'place_address', 'rooms_in_the_apartment', 'material_housing',
            'floor', 'floors_in_the_house', 'area_of_property', 'price', 'condition'], 'required',
        'on' => 'sellingApatrment'
    ],
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'place_street', 'place_house', 'place_address', 'rooms_in_the_apartment', 'material_housing', 'floor',
            'floors_in_the_house', 'area_of_property', 'lease_term', 'price', 'price_for_the_period', 'necessary_furniture', 'internet', 'pets_allowed', 'condition'], 'required',
        'on' => 'rentApatrment'
    ],
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'price'], 'required',
        'on' => 'buyApatrment'
    ],
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'lease_term', 'price', 'price_for_the_period'], 'required',
        'on' => 'rentingApatrment'
    ],
    ['property', 'compare', 'compareValue' => 2, 'operator' => '==',
        'on' => [
            'apartments',
            'sellingApatrment',
            'rentApatrment',
            'buyApatrment',
            'rentingApatrment'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('property')])],  // значение недвижемости для сделок с комнатами
    ['deal_type', 'number', 'min' => 12, 'max' => 15,
        'on' => [
            'sellingApatrment',
            'rentApatrment',
            'buyApatrment',
            'rentingApatrment'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')])],
    ['type_of_property', 'number', 'min' => 89, 'max' => 90,
        'on' => [
            'sellingApatrment',
            'rentApatrment',
            'buyApatrment',
            'rentingApatrment'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')])],
    ['rooms_in_the_apartment', 'number', 'min' => 81, 'max' => 87,
        'on' => [
            'sellingApatrment',
            'rentApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')])],
    ['material_housing', 'number', 'min' => 112, 'max' => 117,
        'on' => [
            'sellingApatrment',
            'rentApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')])],
    [['floor', 'floors_in_the_house'], 'number', 'min' => 44, 'max' => 74,
        'on' => [
            'sellingApatrment',
            'rentApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')])],
    [['floor', 'floors_in_the_house'], 'validateFloor',
        'on' => [
            'sellingApatrment',
            'rentApatrment',
        ],
    ],
    [['lease_term'], 'number', 'min' => 77, 'max' => 78,
        'on' => [
            'rentApatrment',
            'rentingApatrment'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')])],
    [['price_for_the_period'], 'number', 'min' => 79, 'max' => 80,
        'on' => [
            'rentApatrment',
            'rentingApatrment'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')])],
    [['necessary_furniture'], 'number', 'min' => 110, 'max' => 111,
        'on' => [
            'rentApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('necessary_furniture')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('necessary_furniture')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('necessary_furniture')])],
    [['internet'], 'number', 'min' => 132, 'max' => 133,
        'on' => [
            'rentApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('internet')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('internet')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('internet')])],
    [['pets_allowed'], 'number', 'min' => 125, 'max' => 126,
        'on' => [
            'rentApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('pets_allowed')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('pets_allowed')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('pets_allowed')])],
    [['condition'], 'number', 'min' => 39, 'max' => 41,
        'on' => [
            'sellingApatrment',
            'rentApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')])],
    ['appliances', 'in', 'range' => [118, 119, 120, 121, 122, 123, 124], 'allowArray' => true,
        'on' => 'rentApatrment'
    ],
];