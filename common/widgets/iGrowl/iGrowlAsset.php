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
    /**
     * @inherit
     */
    public $sourcePath = '@bower/igrowl';

    /**
     * @inherit
     */
    public $css = [
        'stylesheets/animate.min.css',
        'stylesheets/igrowl.min.css',
        'stylesheets/font css/feather.css',
        'stylesheets/font css/linecons.css',
        'stylesheets/font css/steadysets.css',
        'stylesheets/font css/vicons.css',
    ];

    public $js = [
        'javascripts/igrowl.min.js',
    ];
}