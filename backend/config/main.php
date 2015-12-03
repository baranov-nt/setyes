<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => 'Управление сайтом',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'layout' => 'basic',
    'modules' => [
        'i18n' => [
            'class' => common\widgets\yii2TranslatePanel\Module::className(),
            'controllerMap' => [
                'default' => common\widgets\yii2TranslatePanel\controllers\DefaultController::className(),
            ],
            // example for set access control to module (if required):
            /*'as access' => [
                'class' => yii\filters\AccessControl::className(),
                'rules' => [
                    'controllers'   => ['i18n/default'],
                    'actions'       => ['index', 'save', 'update', 'rescan', 'clear-cache', 'delete', 'restore'],
                    'allow'         => true,
                    'roles'         => ['translator'],
                ],
            ],*/
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => '',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
