<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 17.12.2015
 * Time: 22:40
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class ChosenAsset extends  AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap-chosen/bootstrap-chosen.css',
    ];
    public $js = [

    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $depends = [
        'yii\web\YiiAsset',
        '\common\widgets\Chosen\AssetBundle',                                           // Подключение выпадающих списков http://harvesthq.github.io/chosen/
    ];
}