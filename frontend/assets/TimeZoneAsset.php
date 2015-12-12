<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 12.12.2015
 * Time: 13:55
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class TimeZoneAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/SendTimeZone.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
