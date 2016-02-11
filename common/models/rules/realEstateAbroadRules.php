<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.01.2016
 * Time: 10:49
 */
return [
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'material_housing', 'area_of_property', 'price', 'condition'], 'required',
        'on' => 'sellingPropertyAbroad'
    ],
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'material_housing', 'lease_term', 'price', 'price_for_the_period', 'necessary_furniture',
            'internet', 'pets_allowed', 'condition'], 'required',
        'on' => 'rentPropertyAbroad'
    ],
    ['property', 'compare', 'compareValue' => 6, 'operator' => '==',
        'on' => [
            'propertyAbroad',
            'sellingPropertyAbroad',
            'rentPropertyAbroad',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('property')])],  // значение недвижемости для сделок с комнатами
    ['deal_type', 'number', 'min' => 26, 'max' => 27,
        'on' => [
            'sellingPropertyAbroad',
            'rentPropertyAbroad',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')])],
    ['type_of_property', 'number', 'min' => 100, 'max' => 101,
        'on' => [
            'sellingPropertyAbroad',
            'rentPropertyAbroad',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')])],
    ['material_housing', 'number', 'min' => 112, 'max' => 117,
        'on' => [
            'sellingPropertyAbroad',
            'rentPropertyAbroad',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')])],
    [['lease_term'], 'number', 'min' => 77, 'max' => 78,
        'on' => [
            'rentPropertyAbroad',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')])],
    [['price_for_the_period'], 'number', 'min' => 79, 'max' => 80,
        'on' => [
            'rentPropertyAbroad',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')])],
    [['necessary_furniture'], 'number', 'min' => 110, 'max' => 111,
        'on' => [
            'rentPropertyAbroad',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('necessary_furniture')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('necessary_furniture')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('necessary_furniture')])],
    [['internet'], 'number', 'min' => 132, 'max' => 133,
        'on' => [
            'rentPropertyAbroad',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('internet')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('internet')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('internet')])],
    [['pets_allowed'], 'number', 'min' => 125, 'max' => 126,
        'on' => [
            'rentPropertyAbroad',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('pets_allowed')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('pets_allowed')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('pets_allowed')])],
    [['condition'], 'number', 'min' => 39, 'max' => 41,
        'on' => [
            'sellingPropertyAbroad',
            'rentPropertyAbroad',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')])],
    ['appliances', 'in', 'range' => [118, 119, 120, 121, 122, 123, 124], 'allowArray' => true,
        'on' => 'rentPropertyAbroad',
    ],
];