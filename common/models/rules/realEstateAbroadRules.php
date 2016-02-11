<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.01.2016
 * Time: 10:49
 */
return [
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'place_street', 'place_house', 'place_address', 'rooms_in_the_apartment', 'material_housing',
            'floor', 'floors_in_the_house', 'area_of_property', 'price', 'condition'], 'required',
        'on' => 'sellingPropertyAbroad'
    ],
    [
        ['property', 'deal_type', 'type_of_property', 'place_city', 'place_street', 'place_house', 'place_address', 'rooms_in_the_apartment', 'material_housing',
            'floor', 'floors_in_the_house', 'area_of_property', 'price', 'condition'], 'required',
        'on' => 'rentPropertyAbroad'
    ],
];