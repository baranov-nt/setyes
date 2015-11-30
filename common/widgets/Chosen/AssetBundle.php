<?php
/**
 * AssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\widgets\Chosen;

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
    public $sourcePath = '@common/widgets/Chosen';

    /**
     * @inherit
     */
    public $js = [
        //'app-chosen-select.js',
    ];

    public $depends = [
        'common\widgets\Chosen\ChosenAsset',
    ];
}