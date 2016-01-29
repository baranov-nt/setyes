<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.01.2016
 * Time: 10:49
 */
return [
    ['property', 'compare', 'compareValue' => 7, 'operator' => '==',
        'on' => [
            'comercial',
            'sellingComercial',
            'rentComercial',
            'buyComercial',
            'rentingComercial'
        ],
        'message' => Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel('property')])],
];