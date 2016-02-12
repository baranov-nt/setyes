<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.01.2016
 * Time: 10:48
 */
return [
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'area_of_land', 'measurement_of_land', 'price'], 'required',
        'on' => 'sellingLand'
    ],
    [
        ['property', 'deal_type', 'type_of_property', 'place_city'], 'required',
        'on' => 'buyLand'
    ],
    ['property', 'compare', 'compareValue' => 4, 'operator' => '==',
        'on' => [
            'land',
            'sellingLand',
            'buyLand',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('property')])],  // значение недвижемости для сделок с комнатами
    ['deal_type', 'number', 'min' => 20, 'max' => 21,
        'on' => [
            'sellingLand',
            'buyLand',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')])],
    ['type_of_property', 'number', 'min' => 95, 'max' => 97,
        'on' => [
            'sellingLand',
            'buyLand',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('deal_type')])],
    [['measurement_of_land'], 'number', 'min' => 91, 'max' => 94,
        'on' => [
            'sellingLand',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')]),
        'tooSmall' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')]),
        'tooBig' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('floor')])],
];