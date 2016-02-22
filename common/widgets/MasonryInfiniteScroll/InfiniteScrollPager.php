<?php
/**
 * @link https://github.com/dlds/yii2-infinite-scroll
 * @copyright Copyright (c) 2014 Alexander Stepanov
 * @license GPL-2.0
 */

namespace common\widgets\MasonryInfiniteScroll;

use Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\web\JsExpression;
use common\widgets\MasonryInfiniteScroll\MasonryAsset;

/**
 * InfiniteScrollPager renders a hyperlink that leads to subsequent page of the target and
 * registers infinite-scroll jQuery plugin which uses javascript to fetch and append content
 * for subsequent pages, gracefully degrading to complete page reload when javascript is disabled.
 *
 * InfiniteScrollPager works with a [[Pagination]] object which specifies the total number
 * of pages and the current page number.
 *
 * Several behaviours allowing to customize scroll behavior are provided out of the box,
 * including twitter-style manual trigger, local scroll in overflow div, masonry integration and others.
 * For more examples and documentation visit https://github.com/paulirish/infinite-scroll
 *
 * @author Alexander Stepanov <student_vmk@mail.ru>
 */
class InfiniteScrollPager extends Widget
{
    const BEHAVIOR_MASONRY = 'masonry';

    /**
     * @var string owner widget id
     */
    public $widgetId;
    /**
     * @var string CSS class of a tag that encapsulates items
     */
    public $itemsCssClass;
    /**
     * @var array infinite-scroll jQuery plugin options
     */
    public $pluginOptions = [];
    /**
     * @var string|JsExpression javascript callback to be executed on loading the content via ajax call
     */
    public $contentLoadedCallback;

    /**
     * @var Pagination the pagination object that this pager is associated with.
     * You must set this property in order to make InfiniteScrollPager work.
     */
    public $pagination;
    /**
     * @var array HTML attributes for the pager container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'pagination'];
    /**
     * @var array HTML attributes for the link in a pager container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $linkOptions = [];
    /**
     * @var string the CSS class for the "next" page button.
     */
    public $nextPageCssClass = 'next';
    /**
     * @var string the CSS class for the disabled page buttons.
     */
    public $disabledPageCssClass = 'disabled';
    /**
     * @var string the label for the "next" page button. Note that this will NOT be HTML-encoded.
     */
    public $nextPageLabel = 'Load more';
    /**
     * @var boolean whether to register link tag in the HTML header for next page.
     * Defaults to `false` to avoid conflicts when multiple pagers are used on one page.
     * @see http://www.w3.org/TR/html401/struct/links.html#h-12.1.2
     * @see registerLinkTags()
     */
    public $registerLinkTags = false;
    /**
     * @var boolean Hide widget when only one page exist.
     */
    public $hideOnSinglePage = true;

    /**
     * Initializes the pager.
     */
    public function init()
    {
        if ($this->pagination === null) {
            throw new InvalidConfigException('The "pagination" property must be set.');
        }

        $view = $this->getView();

        /* Регистрация масонри */
        MasonryAsset::register($view);
        /* Регистрация бесконечного скролла */
        InfiniteScrollAsset::register($view);

        /* Инициализация масонри */
        $js = <<< JS
        $(document).ready(function () {
            $('.grid').masonry({
              itemSelector: '.grid-item',
              percentPosition: true
            });

        });
JS;
        $view->registerJs($js);

        // Установка свойств selectors / options https://github.com/infinite-scroll/infinite-scroll
        if (is_null(ArrayHelper::getValue($this->pluginOptions, 'maxPage', null)))
            $this->pluginOptions['maxPage'] = $this->pagination->getPageCount();
    }

    /**
     * Executes the widget.
     * This method displays generated navigation links and initializes infinite-scroll plugin.
     */
    public function run()
    {
        $this->initializeInfiniteScrollPlugin();
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }
        echo $this->renderPageButtons();
    }

    /**
     * Registers relational link tags in the html header for prev, next, first and last page.
     * These links are generated using [[\yii\data\Pagination::getLinks()]].
     * @see http://www.w3.org/TR/html401/struct/links.html#h-12.1.2
     */
    protected function registerLinkTags()
    {
        $view = $this->getView();
        foreach ($this->pagination->getLinks() as $rel => $href) {
            $view->registerLinkTag(['rel' => $rel, 'href' => $href], $rel);
        }
    }

    /**
     * Renders the page buttons.
     * @return string the rendering result
     */
    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            /* Кнопка внизу "Load more items" */
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1);
        }
        return Html::tag('ul', implode("\n", $buttons), $this->options);
    }

    /**
     * Renders a page button.
     * You may override this method to customize the generation of page buttons.
     * @param string $label the text label for the button
     * @param integer $page the page number
     * @param string $class the CSS class for the page button.
     * @param boolean $disabled whether this page button is disabled
     * @return string the rendering result
     */
    protected function renderPageButton($label, $page, $class, $disabled)
    {
        $options = ['class' => $class === '' ? null : $class];
        //dd($options);
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return Html::tag('li', Html::tag('span', $label), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        return Html::tag('li', Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }

    /* Инициализация плагина */
    protected function initializeInfiniteScrollPlugin()
    {
        $pluginOptions = array_filter($this->pluginOptions);                // Removing null entries
        $pluginOptions['loading'] = array_filter(
            ArrayHelper::getValue($this->pluginOptions, 'loading', null));  // Removing null entries
        if (empty($pluginOptions['loading']))
            unset($pluginOptions['loading']);



        //dd([$pluginOptions]);

        $pluginOptions = Json::encode($pluginOptions);

        if (!$this->contentLoadedCallback instanceof JsExpression) {
            $this->contentLoadedCallback = new JsExpression($this->contentLoadedCallback);
        }
        $contentLoadedCallback = Json::encode($this->contentLoadedCallback);

        $this->view->registerJs("$('" . $this->pluginOptions['contentSelector'] . "').infinitescroll(" . $pluginOptions . ", " . $contentLoadedCallback . ");",
            View::POS_END, $this->widgetId . '-infinite-scroll');
    }
}

?>

