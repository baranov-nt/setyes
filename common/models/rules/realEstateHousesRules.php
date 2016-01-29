<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.01.2016
 * Time: 10:47
 */
return [
    ['property', 'compare', 'compareValue' => 3, 'operator' => '==',
        'on' => [
            'houses',
            'sellingHouse',
            'rentHouse',
            'buyHouse',
            'rentingHouse'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('property')])],  // значение недвижемости для сделок с домами
];