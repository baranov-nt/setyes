<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 12.12.2015
 * Time: 13:55
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class JsCookieAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $depends = [
        'yii\web\YiiAsset',
        '\common\widgets\JsCookie\AssetBundle',                                         // Подключение управление cookie https://github.com/js-cookie/js-cookie
    ];
}
