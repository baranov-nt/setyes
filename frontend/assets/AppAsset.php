<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/element-style.css',
        'css/site.css',
        'css/main.css',
        'css/modal.css',
        'css/icon-spin.css',
        'css/fonts.css',
    ];
    public $js = [
        'js/main.js',
        'js/notification.js',
        //'js/liveStream.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'justinvoelker\awesomebootstrapcheckbox\Asset',
    ];
}

