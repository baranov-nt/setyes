<?php
/**
 * AssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\widgets\Semantic;

use Yii;

/**
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 */
class AssetBundle extends \yii\web\AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/bower/semantic';

    public $css = [
        'dist/semantic.css',
        'dist/components/accordion.css',
        'dist/components/ad.css',
        'dist/components/breadcrumb.css',
        'dist/components/button.css',
        'dist/components/card.css',
        'dist/components/checkbox.css',
        'dist/components/comment.css',
        'dist/components/container.css',
        'dist/components/dimmer.css',
        'dist/components/divider.css',
        'dist/components/dropdown.css',
        'dist/components/embed.css',
        'dist/components/feed.css',
        'dist/components/flag.css',
        'dist/components/form.css',
        'dist/components/grid.css',
        'dist/components/header.css',
        'dist/components/icon.css',
        'dist/components/image.css',
        'dist/components/input.css',
        'dist/components/item.css',
        'dist/components/label.css',
        'dist/components/list.css',
        'dist/components/loader.css',
        'dist/components/menu.css',
        'dist/components/message.css',
        'dist/components/modal.css',
        'dist/components/nag.css',
        'dist/components/popup.css',
        'dist/components/progress.css',
        'dist/components/rail.css',
        'dist/components/rating.css',
        'dist/components/reveal.css',
        'dist/components/search.css',
        'dist/components/segment.css',
        'dist/components/shape.css',
        'dist/components/sidebar.css',
        'dist/components/site.css',
        'dist/components/statistic.css',
        'dist/components/step.css',
        'dist/components/sticky.css',
        'dist/components/tab.css',
        'dist/components/table.css',
        'dist/components/transition.css',
    ];

    public $js = [
        'examples/assets/show-examples.js',
        'dist/semantic.js',
        'dist/components/accordion.js',
        'dist/components/api.js',
        'dist/components/checkbox.js',
        'dist/components/colorize.js',
        'dist/components/dimmer.js',
        'dist/components/dropdown.js',
        'dist/components/embed.js',
        'dist/components/form.js',
        'dist/components/modal.js',
        'dist/components/nag.js',
        'dist/components/popup.js',
        'dist/components/progress.js',
        'dist/components/rating.js',
        'dist/components/search.js',
        'dist/components/shape.js',
        'dist/components/sidebar.js',
        'dist/components/site.js',
        'dist/components/state.js',
        'dist/components/sticky.js',
        'dist/components/tab.js',
        'dist/components/transition.js',
        'dist/components/video.js',
        'dist/components/visibility.js',
        'dist/components/visit.js',
    ];
}