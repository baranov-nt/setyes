<?php
/**
 * @link https://github.com/dlds/yii2-infinite-scroll
 * @copyright Copyright (c) 2014 Alexander Stepanov
 * @license MIT
 */

namespace common\widgets\MasonryInfiniteScroll;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Alexander Stepanov <student_vmk@mail.ru>
 */
class InfiniteScrollAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-infinite-scroll';
    public $css = [
    ];
    public $js = [  // Подключение плагина бесконечного скролла
        'jquery.infinitescroll.min.js',
        'behaviors/masonry-isotope.js',         // поведение масонри
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
