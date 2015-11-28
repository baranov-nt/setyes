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
    public $sourcePath = '@vendor/bower/semantic/dist';

    public $css = [
        'semantic.css',
        'components/accordion.css',
        'components/ad.css',
        'components/breadcrumb.css',
        'components/button.css',
        'components/card.css',
        'components/checkbox.css',
        'components/comment.css',
        'components/container.css',
        'components/dimmer.css',
        'components/divider.css',
        'components/dropdown.css',
        'components/embed.css',
        'components/feed.css',
        'components/flag.css',
        'components/form.css',
        'components/grid.css',
        'components/header.css',
        'components/icon.css',
        'components/image.css',
        'components/input.css',
        'components/item.css',
        'components/label.css',
        'components/list.css',
        'components/loader.css',
        'components/menu.css',
        'components/message.css',
        'components/modal.css',
        'components/nag.css',
        'components/popup.css',
        'components/progress.css',
        'components/rail.css',
        'components/rating.css',
        'components/reveal.css',
        'components/search.css',
        'components/segment.css',
        'components/shape.css',
        'components/sidebar.css',
        'components/site.css',
        'components/statistic.css',
        'components/step.css',
        'components/sticky.css',
        'components/tab.css',
        'components/table.css',
        'components/transition.css',
    ];

    public $js = [
        'show-examples.js',
        'semantic.js',
        'components/accordion.js',
        'components/api.js',
        'components/checkbox.js',
        'components/colorize.js',
        'components/dimmer.js',
        'components/dropdown.js',
        'components/embed.js',
        'components/form.js',
        'components/modal.js',
        'components/nag.js',
        'components/popup.js',
        'components/progress.js',
        'components/rating.js',
        'components/search.js',
        'components/shape.js',
        'components/sidebar.js',
        'components/site.js',
        'components/state.js',
        'components/sticky.js',
        'components/tab.js',
        'components/transition.js',
        'components/video.js',
        'components/visibility.js',
        'components/visit.js',
    ];
}