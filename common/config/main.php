<?php
return [
    'name' => 'setYes',
    'language' => 'ru',
    'charset' => 'UTF-8',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'userAgentParser' => [
            'class' => \yii\useragentparser\UserAgentParser::className(),
            'nameHttpPropertyUserAgent' => 'HTTP_USER_AGENT'
        ],
        // Google Maps Image and Geocode API settings for \Yii::$app->googleApi component
        'googleApi'   => [
            //'class'             => \common\widgets\GoogleApi\GoogleApiLibrary::className(),
            'class'             => \common\widgets\GoogleMapsMarkers\GoogleMaps::className(),
            // API Keys !!!
            //'staticmap_api_key' => 'r5peFAnxyUPVqnsgUBUchHozO10=',
            'geocode_api_key'   => 'AIzaSyBn0XnEmdPDw9ku7H66JT4_9KN7IXDZfcA',

            // Set basePath
            'webroot'           => '@webroot',

            // Image path and map iframe settings
            'map_language'        => 'en',
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LcWAxMTAAAAAD2teUNSJdJ8OwfQuqIUyJJDW79j',
            'secret' => '6LcWAxMTAAAAAEZCbXGi-azhHhA8kYRq5WmY9pLg',
        ],
        'redis' => [
            'class' => \yii\redis\Connection::className(),
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
            'dataTimeout' => 30
        ],
        'cache' => [
            //'class' => 'yii\caching\FileCache',
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 1,
            ],
        ],
        'session' => [
            'class' => 'yii\redis\Session',
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 2,
            ],
            //'timeout' => 30,
            //'cookieParams' => ['httponly' => true, 'lifetime' => 3600 * 4],
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
            //'dateFormat' => 'full',                               // объем информации о дате (short, medium, long, full)
            //'dateFormat' => 'dd-MM-yyyy',                         // ICU format
            //'dateFormat' => 'php:d mm Y',                           // PHP date()-format
            'datetimeFormat' => 'php:d.mm.Y H:s',
            //'datetimeFormat' => 'full',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'RUB',
        ],
        /*'urlManager' => [
            
        ],*/
        'i18n' => [
            'class'      => common\widgets\yii2TranslatePanel\components\I18N::className(),
            'languages' => ['ru', 'de', 'fr'],
            'format'     => 'db',
            'sourcePath' => [
                __DIR__ . '/../../frontend',
                __DIR__ . '/../../backend',
                __DIR__ . '/../../common',
                __DIR__ . '/../../console',
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
