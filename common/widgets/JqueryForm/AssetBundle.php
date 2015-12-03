<?php
/**
 * AssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\widgets\JqueryForm;

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
    public $sourcePath = '@bower/jquery-form';

    /**
     * @inherit
     */
    public $js = [
        'jquery.form.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}