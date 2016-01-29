<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.01.2016
 * Time: 10:48
 */
return [
    ['property', 'compare', 'compareValue' => 5, 'operator' => '==',
        'on' => [
            'garages',
            'sellingGarage',
            'rentGarage',
            'buyGarage',
            'rentingGarage'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('property')])],
];