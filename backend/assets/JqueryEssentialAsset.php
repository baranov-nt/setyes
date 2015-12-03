<?php

namespace backend\assets;

use yii\web\AssetBundle;

class JqueryEssentialAsset extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
        '\common\widgets\JQueryCookie\JqueryCookieAsset',                               // Подключение управления cookie
        '\common\widgets\Easing\AssetBundle',                                           // Подключение управления течением анимации https://github.com/danro/easing-js и http://easings.net/ru
        '\common\widgets\MouseWheel\AssetBundle',                                       // Подключение управления колесим мыши https://github.com/jquery/jquery-mousewheel
        '\common\widgets\ScrollTo\AssetBundle',                                         // Подключение скролла http://xiper.net/collect/js-plugins/effects/scrollto*/
        '\common\widgets\JqueryForm\AssetBundle',                                       // Подключение отправки формы ajax https://github.com/malsup/form
    ];
}
