<?php

namespace common\widgets\JQueryCookie;

class JqueryCookieAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/jquery-cookie';
    public $js = [
        'jquery.cookie.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
