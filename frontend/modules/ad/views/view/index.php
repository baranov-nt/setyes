<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use common\widgets\iGrowl\AssetBundle;
use common\widgets\MasonryInfiniteScroll\InfiniteScrollPager;
use yii\widgets\Pjax;
use yii\helpers\Url;

AssetBundle::register($this);

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container" >
    <?php
    if(Yii::$app->controller->action->id == 'my') {
        $this->title = Yii::t('app', 'My ads');
    } elseif(Yii::$app->controller->action->id == 'favorites') {
        $this->title = Yii::t('app', 'Selected ads');
    } elseif(Yii::$app->controller->action->id == 'one') {
        $this->title = Yii::t('app', 'Related ads');
    } else {
        $this->title = Yii::t('app', 'List of ads').': '.Yii::$app->placeManager->getCityName();
    }
    ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    Pjax::begin([
        'timeout' => 9000,
        'enablePushState' => true
    ]);
    ?>
    <div class="row" style="margin: 20px 0 20px 0 !important;">
        <div class="col-md-12">
            <?php
            if(Yii::$app->controller->action->id == 'all' || Yii::$app->controller->action->id == 'show-in-region'):
                $city = Yii::$app->request->cookies->get('_cityId');
                if(isset($city)):
                    if(Yii::$app->controller->action->id != 'show-in-region'):
                        ?>
                        <?= Html::a(Yii::t('app', 'Show ads in the region.').' <span class="fa fa-spinner fa-spin" style="display: none;"></span>', Url::to(['/ad/view/show-in-region']),
                        [
                            'class' => 'btn btn-default',
                            'onclick' => '$(".fa-spinner").show();'
                        ]) ?>
                        <?php
                    else:
                        ?>
                        <?= Html::a(Yii::t('app', 'Show ads in the city.').' <span class="fa fa-spinner fa-spin" style="display: none;"></span>', Url::to(['/ad/view/all']),
                        [
                            'class' => 'btn btn-default',
                            'onclick' => '$(".fa-spinner").show();'
                        ]) ?>
                        <?php
                    endif;
                endif;
            endif;
            ?>
        </div>
    </div>
    <div class="ad-main-index list-view">
        <?php
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'id' => 'my-listview-id',
            'itemView' => function ($modelAdMain, $key, $index, $widget) {                // альтернативный способ передать данные в представление
                // $var $model \common\models\AdMain
                return $this->render('_item' ,[
                    'modelAdMain' => $modelAdMain,
                    'key' => $key,
                    'index' => $index,
                    'widget' => $widget
                ]);
            },
            'itemOptions' => [                                                      // свойства для элементов контейнера
                'tag' => 'div',
                'class' => 'grid-item col-md-3 col-sm-6 item-pjax',
            ],
            'layout' => "<div class=\"items grid\">{items}</div>{pager}",
            'pager' => [
                'class' => InfiniteScrollPager::className(),
                'widgetId' => 'my-listview-id',
                'itemsCssClass' => 'items',
                'contentLoadedCallback' => 'afterAjaxListViewUpdate',
                'nextPageLabel' => '',
                'linkOptions' => [
                    'class' => '',
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
    <?php
    Pjax::end();
    ?>
</div>
<?php
echo $this->render('_modal-window');
?>
<div class="clearfix"></div>
