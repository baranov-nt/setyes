<?php
/**
 * AssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\widgets\ScrollToTop;

use Yii;
/**app-scroll-to-top.css
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/scroll-to-top';
    public $js = [
        'jquery.scrollToTop.min.js',
    ];
    public $depends = [
        '\common\widgets\ScrollToTop\ScrollToTopAsset',                            // Подключение Bootstrap подтверждения окна
    ];
}