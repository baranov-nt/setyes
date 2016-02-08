<?php

namespace common\widgets\StepsNavigation\assets;

use yii\web\AssetBundle;

/**
 * CropperAsset
 *
 * Установка - composer require "bower-asset/cropper"
 *
 */
class StepsAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/StepsNavigation';
    public $css = [
        'css/steps.css',
    ];
    public $js = [
        'js/steps.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
