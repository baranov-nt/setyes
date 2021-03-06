<?php
/**
 * AssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\widgets\ScrollTo;

use Yii;
/**
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 */
class AssetBundle extends \yii\web\AssetBundle
{
    /**
     * @inherit
     */
    public $sourcePath = '@bower/jquery.scrollTo';

    /**
     * @inherit
     */
    public $js = [
        'jquery.scrollTo.js',
    ];

    public $depends = [
        '\common\widgets\Easing\AssetBundle',                                           // Подключение управления течением анимации https://github.com/danro/easing-js и http://easings.net/ru
    ];
}