<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.01.2016
 * Time: 10:49
 */
return [
    ['property', 'compare', 'compareValue' => 6, 'operator' => '==',
        'on' => [
            'propertyAbroad',
            'sellingPropertyAbroad',
            'buyPropertyAbroad',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('property')])],  // значение недвижемости для сделок с домами
];