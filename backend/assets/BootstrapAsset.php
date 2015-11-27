<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.11.2015
 * Time: 13:42
 */

namespace backend\assets;

use yii\web\AssetBundle;

class BootstrapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $depends = [
        'yii\web\YiiAsset',
        '\common\widgets\FontAwesome\AssetBundle',                                      // Подключение FontAwesome
        '\common\widgets\BootstrapConfirmation\AssetBundle',                            // Подключение Bootstrap подтверждения окна
        '\common\widgets\ScrollToTop\AssetBundle',                                      // Подключение Bootstrap подтверждения окна
    ];
}
