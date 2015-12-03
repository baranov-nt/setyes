<?php
/**
 * AssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\widgets\iGrowl;

use Yii;
/**
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 */
class iGrowlAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/widgets/iGrowl/assets';
    public $css = [
        'iGrowl/dist/css/igrowl.min.css',
        'iGrowl/dist/css/fonts/steadysets.css',
        'app-igrowl.css',
    ];
    public $js = [
        'iGrowl/dist/js/igrowl.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        '\common\widgets\Animate_css\AssetBundle',                                      // Подключение animate.css https://github.com/daneden/animate.css
    ];
}