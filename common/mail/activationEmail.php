<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 26.08.2015
 * Time: 11:42
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

echo Html::a(Yii::t('app', 'To activate your account please follow this link.'),
    Yii::$app->urlManager->createAbsoluteUrl(
        [
            '/main/activate-account',
            'key' => $user->secret_key
        ]
    ));
