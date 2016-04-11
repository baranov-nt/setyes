<?php
/**
 * AssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\widgets\Draggable;

use Yii;
/**
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/draggable';

    public $js = [
        'draggable.min.js',
    ];
}