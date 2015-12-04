<?php

namespace common\widgets\yii2TranslatePanel\assets;

class AppTranslateAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/widgets/yii2TranslatePanel/web';
    public $css = [
        'css/translate.css',
    ];
    public $js = [
        'js/translate.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\JqueryEssentialAsset',
        'common\widgets\yii2TranslatePanel\assets\AppAjaxButtonsAsset',
        'common\widgets\Chosen\AssetBundle',                                           // Подключение выпадающих списков http://harvesthq.github.io/chosen/
    ];
}
