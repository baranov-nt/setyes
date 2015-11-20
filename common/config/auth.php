<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30.10.2015
 * Time: 14:18
 */
return [
    // клиент для авторизации через соц сети
    'class' => 'yii\authclient\Collection',
    'clients' => [
        'google' => [
            'class' => 'yii\authclient\clients\GoogleOAuth',
            'clientId' => '---',
            'clientSecret' => '---',
        ],
        'yandex' => [
            'class' => 'yii\authclient\clients\YandexOAuth',
            'clientId' => '---',
            'clientSecret' => '---',
            // Callback URL: http://boyar-nt.ru/site/auth?authclient=yandex
        ],
        'facebook' => [
            'class' => 'yii\authclient\clients\Facebook',
            'clientId' => '---',
            'clientSecret' => '---',
        ],
        'vkontakte' => [
            'class' => 'yii\authclient\clients\VKontakte',
            'clientId' => '---',
            'clientSecret' => '---',
        ],
        'twitter' => [
            'class' => 'yii\authclient\clients\Twitter',
            'consumerKey' => '---',
            'consumerSecret' => '---',
        ],
        'linkedin' => [
            'class' => 'yii\authclient\clients\LinkedIn',
            'clientId' => '---',
            'clientSecret' => '---',
        ],
        // Callback URL: http://boyar-nt.ru/site/auth?authclient=linkedin
    ]
];