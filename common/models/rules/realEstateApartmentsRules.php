<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 27.01.2016
 * Time: 19:44
 */
return [
    [['type_of_property', 'property', 'deal_type', 'place_city', 'place_street', 'place_house', 'rooms_in_the_apartment', 'material_housing',
        'floor', 'price', 'area', 'floors_in_the_house', 'condition'], 'required',
        'on' => 'sellingApatrment'
    ],
    [['type_of_property', 'property', 'deal_type', 'place_city', 'place_street', 'place_house', 'rooms_in_the_apartment', 'material_housing', 'floor', 'price', 'area', 'floors_in_the_house', 'lease_term',
        'price_for_the_period', 'necessary_furniture', 'internet', 'pets_allowed', 'condition'], 'required',
        'on' =>
            'rentAApatrment'
    ],
    ['property', 'compare', 'compareValue' => 2, 'operator' => '==',
        'on' => [
            'apartments',
            'sellingApatrment',
            'rentAApatrment',
            'buyApatrment',
            'rentingAApatrment'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('property')])],  // значение недвижемости для сделок с квартирами
    ['deal_type', 'number', 'min' => 12, 'max' => 15,
        'on' => [
            'sellingApatrment',
            'rentAApatrment',
            'buyApatrment',
            'rentingAApatrment'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')])],
    ['type_of_property', 'number', 'min' => 89, 'max' => 90,
        'on' => [
            'apartments',
            'sellingApatrment',
            'rentAApatrment',
            'buyApatrment',
            'rentingAApatrment'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('type_of_property')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('type_of_property')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('type_of_property')])],
    ['rooms_in_the_apartment', 'number', 'min' => 81, 'max' => 88,
        'on' => [
            'sellingApatrment',
            'rentAApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('rooms_in_the_apartment')])],
    ['material_housing', 'number', 'min' => 112, 'max' => 117,
        'on' => [
            'sellingApatrment',
            'rentAApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('material_housing')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('material_housing')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('material_housing')])],
    [['floor', 'floors_in_the_house'], 'number', 'min' => 44, 'max' => 74,
        'on' => [
            'sellingApatrment',
            'rentAApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')])],
    [['lease_term'], 'number', 'min' => 77, 'max' => 78,
        'on' => [
            'rentAApatrment',
            'rentingAApatrment'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('lease_term')])],
    [['price_for_the_period'], 'number', 'min' => 79, 'max' => 80,
        'on' => [
            'rentAApatrment',
            'rentingAApatrment'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('price_for_the_period')])],
    [['necessary_furniture'], 'number', 'min' => 110, 'max' => 111,
        'on' => [
            'rentAApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('necessary_furniture')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('necessary_furniture')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('necessary_furniture')])],
    [['internet'], 'number', 'min' => 39, 'max' => 40,
        'on' => [
            'rentAApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('internet')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('internet')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('internet')])],
    [['pets_allowed'], 'number', 'min' => 125, 'max' => 126,
        'on' => [
            'rentAApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('pets_allowed')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('pets_allowed')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('pets_allowed')])],
    [['condition'], 'number', 'min' => 41, 'max' => 43,
        'on' => [
            'sellingApatrment',
            'rentAApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')])],
    [['appliances'], 'number', 'min' => 118, 'max' => 124,
        'on' => [
            'rentAApatrment',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('appliances')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('appliances')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('condition')])],
];