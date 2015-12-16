<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.12.2015
 * Time: 14:12
 */

use common\widgets\GoogleMapsMarkers\GoogleMaps;

//$object = \Yii::$app->googleApi->getGeoCodeObject(\Yii::$app->getRequest()->getCookies()->getValue('_city'), null);
//$object = \Yii::$app->googleApi->getGeoCodeObject('gorod Nizhniy Tagil', null);
//d($object);


echo GoogleMaps::widget([
    'googleMapsUrlOptions' => [
        //'key' => Yii::$app->googleApi->geocode_api_key,
        'language' => Yii::$app->language,
        'version' => '3.1.18'
    ],
    'googleMapsOptions' => [
        'mapTypeId' => ['roadmap', 'map_style'],
        //'tilt' => 45,
        'zoom' => 1
    ]
]);

//d(Yii::$app->googleApi->geocode_api_key);
?>