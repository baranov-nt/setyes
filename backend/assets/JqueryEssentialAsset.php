<?php

namespace backend\assets;

use yii\web\AssetBundle;

class JqueryEssentialAsset extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
        'uran1980\yii\assets\jQueryEssential\JqueryCookieAsset',
        '\common\widgets\Easing\AssetBundle',                                           // Подключение управления течением анимации https://github.com/danro/easing-js и http://easings.net/ru
        '\common\widgets\MouseWheel\AssetBundle',                                       // Подключение управления колесим мыши https://github.com/jquery/jquery-mousewheel
        '\common\widgets\ScrollTo\AssetBundle',                                         // Подключение скролла http://xiper.net/collect/js-plugins/effects/scrollto*/
        '\common\widgets\JqueryForm\AssetBundle',                                       // Подключение отправки формы ajax https://github.com/malsup/form
    ];
}
