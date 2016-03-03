<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.01.2016
 * Time: 10:49
 */
return [
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'place_street', 'place_house', 'place_address', 'material_housing',
            'floors_in_the_house', 'area_of_property', 'price', 'condition'], 'required',
        'on' => 'sellingComercial'
    ],
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'place_street', 'place_house', 'place_address', 'material_housing',
            'floors_in_the_house', 'area_of_property', 'price', 'price_for_the_period', 'condition'], 'required',
        'on' => 'rentComercial'
    ],
    [
        ['property', 'deal_type', 'type_of_property', 'place_city'], 'required',
        'on' => 'buyComercial'
    ],
    [
        ['property', 'deal_type', 'type_of_property', 'place_city'], 'required',
        'on' => 'rentingComercial'
    ],
    ['property', 'compare', 'compareValue' => 6, 'operator' => '==',
        'on' => [
            'apartments',
            'sellingApatrment',
            'rentApatrment',
            'buyApatrment',
            'rentingApatrment'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('property')])],
    ['deal_type', 'number', 'min' => 28, 'max' => 31,
        'on' => [
            'sellingApatrment',
            'rentApatrment',
            'buyApatrment',
            'rentingApatrment'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')])],
    ['type_of_property', 'number', 'min' => 102, 'max' => 107,
        'on' => [
            'sellingApatrment',
            'rentApatrment',
            'buyApatrment',
            'rentingApatrment'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')])],
    ['material_housing', 'number', 'min' => 112, 'max' => 117,
        'on' => [
            'sellingApatrment',
            'rentApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')])],
    [['floor', 'floors_in_the_house'], 'number', 'min' => 43, 'max' => 74,
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
    [['condition'], 'number', 'min' => 39, 'max' => 41,
        'on' => [
            'sellingApatrment',
            'rentApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')])],
];