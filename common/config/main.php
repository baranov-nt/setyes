<?php
return [
    'name' => 'SetYes.Com',
    'language' => 'en',
    'charset' => 'UTF-8',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        // Google Maps Image and Geocode API settings for \Yii::$app->googleApi component
        'googleApi'   => [
            'class'             => \common\widgets\GoogleApi\GoogleApiLibrary::className(),

            // API Keys !!!
            'staticmap_api_key' => 'r5peFAnxyUPVqnsgUBUchHozO10=',
            'geocode_api_key'   => 'AIzaSyBn0XnEmdPDw9ku7H66JT4_9KN7IXDZfcA',

            // Set basePath
            'webroot'           => '@webroot',

            // Image path and map iframe settings
            'map_image_path'    => '/images/google_map',
            'map_type'          => 'terrain',
            'map_size'          => '520x350',
            'map_sensor'        => false,
            'map_zoom'          => 9,
            'map_scale'         => 1,
            'map_marker_color'  => 'red',
            'map_iframe_width'  => '100%', // %, px, em
            'map_iframe_height' => '500px',  // %, px, em
            'map_language'        => 'en',

            // Debug
            'quiet'             => false
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LcWAxMTAAAAAD2teUNSJdJ8OwfQuqIUyJJDW79j',
            'secret' => '6LcWAxMTAAAAAEZCbXGi-azhHhA8kYRq5WmY9pLg',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'authClientCollection' => require(__DIR__ . '/auth.php'),
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            //'forceCopy' => true,                                  // каждый раз чистит assets
        ],
        'formatter' => [                                            // выводит данные в заданом формате
            'defaultTimeZone' => 'UTC',
            'dateFormat' => 'full',                               // объем информации о дате (short, medium, long, full)
            //'dateFormat' => 'dd-MM-yyyy',                         // ICU format
            //'dateFormat' => 'php:d mm Y',                           // PHP date()-format

            'datetimeFormat' => 'full',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'RUB',
        ],
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['ru', 'en', 'de', 'fr'],
        ],
        'i18n' => [
            'class'      => common\widgets\yii2TranslatePanel\components\I18N::className(),
            'languages' => ['ru', 'de', 'fr'],
            'format'     => 'db',
            'sourcePath' => [
                __DIR__ . '/../../frontend',
                __DIR__ . '/../../backend',
                __DIR__ . '/../../common',
            ],
            'messagePath' => __DIR__  . '/../../messages',
            'translations' => [
                '*' => [
                    'class'           => yii\i18n\DbMessageSource::className(),
                    'enableCaching'   => true,
                    'cachingDuration' => 60 * 60 * 2, // cache on 2 hours
                ],
                'yii' => [
                    'class'           => yii\i18n\DbMessageSource::className(),
                    'enableCaching'   => true,
                    'cachingDuration' => 60 * 60 * 2, // cache on 2 hours
                ],
                'app' => [
                    'class'           => yii\i18n\DbMessageSource::className(),
                    'enableCaching'   => true,
                    'cachingDuration' => 60 * 60 * 2, // cache on 2 hours
                ],
            ],
        ],
    ],
];
