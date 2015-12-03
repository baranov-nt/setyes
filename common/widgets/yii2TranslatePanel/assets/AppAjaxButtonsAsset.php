<?php

namespace common\widgets\yii2TranslatePanel\assets;

class AppAjaxButtonsAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/widgets/yii2TranslatePanel/web';
    public $js = [
        'js/app-ajax-buttons.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        //'\common\widgets\FontAwesome\AssetBundle',                                      // Подключение FontAwesome
        '\common\widgets\iGrowl\iGrowlAsset',                                           // Подключение анимированных подсказок http://catc.github.io/iGrowl/#ss-installation
        'uran1980\yii\widgets\igrowl\IgrowlAsset',
        'uran1980\yii\bootstrapConfirmation\BootstrapConfirmationAsset',
    ];
}
