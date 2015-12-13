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
        '\common\widgets\ScrollToTop\AssetBundle',                                      // Подключение Bootstrap прокрутка вверх
        '\common\widgets\Semantic\AssetBundle',                                         // Подключение Semantic http://semantic-ui.com/
        '\common\widgets\Animate_css\AssetBundle',                                      // Подключение animate.css https://github.com/daneden/animate.css
        '\common\widgets\iGrowl\AssetBundle',                                           // Подключение анимированных подсказок http://catc.github.io/iGrowl/#ss-installation
        '\common\widgets\Chosen\AssetBundle',                                           // Подключение выпадающих списков http://harvesthq.github.io/chosen/
        '\common\widgets\JsCookie\AssetBundle',                                         // Подключение управление cookie https://github.com/js-cookie/js-cookie
        '\common\widgets\Easing\AssetBundle',                                           // Подключение управления течением анимации https://github.com/danro/easing-js и http://easings.net/ru
        '\common\widgets\MouseWheel\AssetBundle',                                       // Подключение управления колесим мыши https://github.com/jquery/jquery-mousewheel
        '\common\widgets\JqueryForm\AssetBundle',                                       // Подключение отправки формы ajax https://github.com/malsup/form
        '\common\widgets\ScrollTo\AssetBundle',                                         // Подключение скролла http://xiper.net/collect/js-plugins/effects/scrollto
    ];
}
