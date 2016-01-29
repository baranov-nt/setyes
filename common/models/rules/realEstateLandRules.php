<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.01.2016
 * Time: 10:48
 */
return [
    ['property', 'compare', 'compareValue' => 4, 'operator' => '==',
        'on' => [
            'land',
            'sellingLand',
            'buyLand',
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('property')])],  // значение недвижемости для сделок с домами
];