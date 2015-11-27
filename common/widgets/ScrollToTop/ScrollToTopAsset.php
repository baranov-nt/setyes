<?php

namespace common\widgets\ScrollToTop;

class ScrollToTopAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/widgets/ScrollToTop';
    public $css = [
        'assets\css\app-scroll-to-top.css',
    ];
    public $js = [
        'assets\js\app-scroll-to-top.js',
    ];
}
