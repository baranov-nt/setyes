<?php
return [
    'name' => 'SetYes.Com',
    'language' => 'ru',
    'charset' => 'UTF-8',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
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
            'languages' => ['en', 'fr', 'de', 'ru'],
        ],
        /*'urlManager' => [
            'class'             => yii\web\UrlManager::className(),
            'enablePrettyUrl'   => true,
            'showScriptName'    => false, // false - means that index.php will not be part of the URLs
        ],*/
        'i18n' => [
            'class'      => common\widgets\yii2TranslatePanel\components\I18N::className(),
            'languages'  => ['en', 'de', 'fr', 'ru'],
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
            ],
        ],
    ],
];
