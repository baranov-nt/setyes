<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use common\widgets\iGrowl\AssetBundle;
use common\widgets\MasonryInfiniteScroll\InfiniteScrollPager;

AssetBundle::register($this);

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="container" style="margin-bottom: 20px !important;">
        <div style="padding-left: 20px !important;">
            <?php
            if(Yii::$app->controller->action->id == 'all') {
                $this->title = Yii::t('app', 'List of ads');
            } elseif(Yii::$app->controller->action->id == 'my') {
                $this->title = Yii::t('app', 'My ads');
            } elseif(Yii::$app->controller->action->id == 'favorites') {
                $this->title = Yii::t('app', 'Selected ads');
            } elseif(Yii::$app->controller->action->id == 'one') {
                $this->title = Yii::t('app', 'Related ads');
            }
            ?>
            <h1><?= Html::encode($this->title) ?></h1>
            <div class="ad-main-index list-view">
                <?php


                echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'id' => 'my-listview-id',
                    'itemView' => function ($model, $key, $index, $widget) {                // альтернативный способ передать данные в представление
                        return $this->render('_category_'.$model->adCategory->category,[
                            'model' => $model->adCategory->ad,
                            'key' => $key,
                            'index' => $index,
                            'widget' => $widget
                        ]);
                    },
                    'itemOptions' => [                                                      // свойства для элементов контейнера
                        'tag' => 'div',
                        'class' => 'grid-item col-md-3 col-sm-6 item-pjax',
                        //'id' => 'list-wrapper',
                        'style' => 'float: left !important;'
                    ],
                    'layout' => "<div class=\"items grid\">{items}{pager}</div>",
                    'pager' => [
                        'class' => InfiniteScrollPager::className(),
                        'widgetId' => 'my-listview-id',
                        'itemsCssClass' => 'items',
                        'contentLoadedCallback' => 'afterAjaxListViewUpdate',
                        'nextPageLabel' => '',
                        'linkOptions' => [
                            'class' => 'grid-item',
                        ],
                        'pluginOptions' => [
                            'loading' => [
                                'msgText' => '<em>'.Yii::t('app', 'Loading next set of ads.').'</em>',
                                'finishedMsg' => '<em>'.Yii::t('app', 'No more ads to load.').'</em>',
                                'img' => '/images/ajax-loader.gif',
                            ],
                            'behavior' => InfiniteScrollPager::BEHAVIOR_MASONRY,
                            'contentSelector' => '#my-listview-id .items',
                            'itemSelector' => '#my-listview-id .items >',
                            'navSelector' => '#my-listview-id ul.pagination',
                            'nextSelector' => '#my-listview-id ul.pagination li.next a:first',
                        ],
                    ],
                ]);
                ?>

            </div>
        </div>
    </div>
<?php
echo $this->render('_modal-window');
?>
<div class="clearfix"></div>
