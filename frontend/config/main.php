<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'timezone'
    ],
    'controllerNamespace' => 'frontend\controllers',
    'layout' => 'basic',
    'defaultRoute' => '/ad/view/all',
    'modules' => [
        'ad' => [
            'class' => 'frontend\modules\ad\Module',
        ],
    ],
    'components' => [
        'timezone' => [
            'class' => 'common\widgets\TimeZone\Timezone',
            'actionRoute' => '/site/timezone' //optional param - full path to page must be specified
        ],
        'request' => [
            'baseUrl' => '',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                /*[
                    'pattern' => '<cityId:\d+>',
                    'route' => '/ad/view/all',
                    'suffix' => ''
                ],*/
                /*[
                    'pattern' => '/<cityId:\d+>/ad/view/all/<page:\d+>/<per-page:\d+>',
                    'route' => '/ad/view/all',
                    'suffix' => ''
                ],
                [
                    'pattern' => '/<cityId:\d+>/ad/view/all',
                    'route' => '/ad/view/all',
                    'suffix' => ''
                ],*/
                [
                    'pattern' => '',
                    'route' => '/ad/view/all',
                    'suffix' => ''
                ],
                [
                    'pattern' => '/view/<action>',
                    'route' => '/ad/view/<action>',
                    'suffix' => ''
                ],
                [
                    'pattern' => 'site/auth',
                    'route' => 'site/auth',
                    'suffix' => ''
                ],
                [
                    'pattern' => 'site/timezone',
                    'route' => 'site/timezone',
                    'suffix' => ''
                ],
                [
                    'pattern' => 'test',
                    'route' => 'test/index',
                    'suffix' => ''
                ],
                [
                    'pattern' => '<cityId:\d+>/<controller>/<action>',
                    'route' => '<controller>/<action>',
                    'suffix' => ''
                ],
                [
                    'pattern' => '<controller>/<action>/<id:\d+>',
                    'route' => '<controller>/<action>',
                    'suffix' => '.html'
                ],
                [
                    'pattern' => '<controller>/<action>',
                    'route' => '<controller>/<action>',
                    'suffix' => '.html'
                ],
                [
                    'pattern' => 'ad',
                    'route' => 'ad/default/index',
                    'suffix' => '.html'
                ],
                [
                    'pattern' => '<cityId:\d+>/<module>/<controller>/<action>/<id:\d+>',
                    'route' => '<module>/<controller>/<action>',
                    'suffix' => ''
                ],
                [
                    'pattern' => '<cityId:\d+>/<module>/<controller>/<action>',
                    'route' => '<module>/<controller>/<action>',
                    'suffix' => ''
                ],
                [
                    'pattern' => '<module>/<controller>/<action>',
                    'route' => '<module>/<controller>/<action>',
                    'suffix' => ''
                ],
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['main/login'],
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
            'errorAction' => 'main/error',
        ],
    ],
    'params' => $params,
];
