<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use common\widgets\Masonry\Masonry;
use common\widgets\iGrowl\AssetBundle;

AssetBundle::register($this);

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;

Masonry::widget();
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
            <div class="ad-main-index">
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    //'layout' => "{summary}\n{items}<div class='col-md-12'>ss{pager}</div>",              // выводит следующии данные summary(вывод количества записей), items(вывод самих записей),
                    // sorter(вывод блока сортировки), pager(вывод пагинации)
                    //'itemView' => 'index',                                                // представление для элементов
                    'itemView' => function ($model, $key, $index, $widget) {                // альтернативный способ передать данные в представление
                        /* @var $model common\models\AdMain */
                        //dd($model->adCategory->category);
                        return $this->render('_category_'.$model->adCategory->category,[
                            'model' => $model->adCategory->ad,
                            'key' => $key,
                            'index' => $index,
                            'widget' => $widget
                        ]);
                        // or just do some echo
                        //return $model->name . ' добавил ' . $model->user->email;
                    },
                    'itemOptions' => [                                                      // свойства для элементов контейнера
                        'tag' => 'div',
                        'class' => 'grid-item col-md-3 col-sm-6',
                        //'id' => 'list-wrapper',
                        //'style' => 'float: left !important;'
                    ],
                    'pager' => [                                                            // параметры для пагинации
                        'firstPageLabel' => 'первая',
                        'lastPageLabel' => 'последняя',
                        'nextPageLabel' => 'следующая',
                        'prevPageLabel' => 'предыдущая',
                        'maxButtonCount' => 3,                                              // количество цифровых кнопок
                    ],
                    //'summary' => "{begin}{end}{count}{totalCount}{page}{pageCount}",      // свойства выводимых данных количества элементов
                    'summary' => false,
                    /*'summaryOptions' => [                                                   // свойства для количества элементов
                        'tag' => 'div',
                        'class' => 'grid-item',
                        'style' => 'display: block !important; width: 100% !important; background-color: red !important; margin-bottom: 20px !important;'
                        //'id' => 'list-wrapper',
                    ],*/
                    'options' => [                                                          // свойства основного контейнера для элементов
                        'tag' => 'div',
                        'class' => 'list-wrapper row grid',
                        'id' => 'list-wrapper',
                    ],

                ]);
                ?>

            </div>
        </div>
    </div>
<?php
echo $this->render('_modal-window');