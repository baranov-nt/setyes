<?php

/**
 * @var View $this
 */
use common\widgets\yii2TranslatePanel\components\grid\GridView;
use common\widgets\yii2TranslatePanel\components\grid\SerialColumn;
use common\widgets\yii2TranslatePanel\components\grid\ActionColumn;
use common\widgets\yii2TranslatePanel\components\grid\DataColumn;
use common\widgets\yii2TranslatePanel\models\search\SourceMessageSearch;
use common\widgets\yii2TranslatePanel\assets\AppTranslateAsset;
use common\widgets\ScrollToTop\ScrollToTop;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

$searchModel = SourceMessageSearch::getInstance();

$this->title = Yii::t('app', 'Translations');
$this->params['breadcrumbs'][] = $this->title;

AppTranslateAsset::register($this);
?>

<div class="translations-index">
    <div class="row">
        <div class="col-lg-12">
            <span class="pull-left btn-group">
            <?php   foreach ( [
                        SourceMessageSearch::STATUS_ALL             => Yii::t('app', 'All'),
                        SourceMessageSearch::STATUS_TRANSLATED      => Yii::t('app', 'Translated'),
                        SourceMessageSearch::STATUS_NOT_TRANSLATED  => Yii::t('app', 'Not Translated'),
                        SourceMessageSearch::STATUS_DELETED         => Yii::t('app', 'Deleted'),
                    ] as $status => $name ) { ?>
                <a class="btn btn-default <?php
                    $params = ArrayHelper::merge(Yii::$app->request->getQueryParams(), [
                        $searchModel->formName() => ['status' => $status],
                    ]);
                    $route = ArrayHelper::merge(['/translate-panel'], $params);
                    echo SourceMessageSearch::isActiveTranslation([
                        'url'       => $route,
                        'current'   => $status,
                    ]); ?>" href="<?php
                    echo Url::to($route); ?>"><?php
                    echo $name; ?></a>
            <?php } ?>
            </span>
        </div>
    </div>
    <h2>
        <?php echo Html::a($this->title, ['/translate-panel']); ?>
        <span class="pull-right btn-group">
            <a class="btn btn-success" href="<?php
                echo Url::to(['/translate-panel/rescan']); ?>"><i class="fa fa-refresh"></i> <?php
                echo Yii::t('app', 'Rescan'); ?></a>
            <a class="btn btn-warning btn-ajax" action="translation-clear-cache"
               before-send-title="<?php echo Yii::t('app', 'Request sent'); ?>"
               before-send-message="<?php echo Yii::t('app', 'Please, wait...'); ?>"
               success-title="<?php echo Yii::t('app', 'Server Response'); ?>"
               success-message="<?php echo Yii::t('app', 'Cache successfully cleared.'); ?>"
               href="<?php
                    echo Url::to(['/translate-panel/clear-cache']); ?>"><i class="fa fa-recycle"></i> <?php
                    echo Yii::t('app', 'Clear Cache'); ?></a>
        </span>
    </h2>
    <?php
    echo GridView::widget([
        'filterModel' => $searchModel,
        'dataProvider' => $searchModel->search(Yii::$app->getRequest()->get()),
        'columns' => [
            // ----------------------------- ID --------------------------------
//            [
//                'attribute' => 'id',
//                'headerOptions' => [
//                    'width' => '30',
//                ],
//                'contentOptions' => [
//                    'class' => 'text-align-center',
//                ],
//                'value' => function ($model, $key, $index, $dataColumn) {
//                    return $model->id;
//                },
//                'filter' => false,
////                'visible' => false,
//            ],
            [
                'class' => SerialColumn::className(),
            ],
            // ----------------------- SOURCE MESSAGES -------------------------
            [
                'attribute' => 'message',
                'format' => 'raw',
                'contentOptions' => [
                    'class' => 'source-message',
                ],
                'value' => function ($model, $key, $index, $column) {
                    return $this->render('_source-message-content', [
                        'model'     => $model,
                        'key'       => $key,
                        'index'     => $index,
                        'column'    => $column,
                    ]);
                },
            ],
            // ----------------------- COPY BUTTON -----------------------------
            [
                'class'  => ActionColumn::className(),
                'header' => '<i class="fa fa-copy"></i>',
                'footer' => '<i class="fa fa-copy"></i>',
                'template' => '{copy}',
                'headerOptions' => [
                    'width' => '30',
                ],
                'buttons' => [
                    'copy' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-arrow-right "></i>', '', [
                            'class' => 'btn btn-xs btn-default btn-translation-copy-from-source',
                            'title' => Yii::t('app', 'Copy from source message'),
                        ]);
                    },
                ],
            ],
            // --------------------- MESSAGE TRANSLATIONS ----------------------
            [
                'attribute' => 'translation',
                'headerOptions' => [
                    'width' => '400',
                ],
                'contentOptions' => [
                    'class' => 'translation-tabs tabs-mini',
                ],
                'value' => function ($model, $key, $index, $column) {
                    return $this->render('_message-tabs', [
                        'model'     => $model,
                        'key'       => $key,
                        'index'     => $index,
                        'column'    => $column,
                    ]);
                },
                'format' => 'raw',
            ],
            // --------------------------- CATEGORY ----------------------------
            [
                'attribute' => 'category',
                'headerOptions' => [
                    'width' => '150',
                ],
                'contentOptions' => [
                    'class' => 'text-align-center',
                ],
                'value' => function ($model, $key, $index, $dataColumn) {
                    return $model->category;
                },
                'filter' => ArrayHelper::map($searchModel::getCategories(), 'category', 'category'),
                'filterInputOptions' => DataColumn::$filterOptionsForChosenSelect,
            ],
            // ---------------------------- STATUS -----------------------------
            [
                'attribute' => 'status',
                'headerOptions' => [
                    'width' => '150',
                ],
                'contentOptions' => [
                    'class' => 'text-align-center',
                ],
                'value' => '',
                'filter' => Html::dropDownList(
                    $searchModel->formName() . '[status]',
                    $searchModel->status,
                    $searchModel->getStatus(),
                    DataColumn::$filterOptionsForChosenSelect
                ),
                'visible' => false,
            ],
            // --------------------------- ACTIONS -----------------------------
            [
                'class' => ActionColumn::className(),
                'template' => '{save} {fullscreen} {delete}',
                'buttons' => [
                    'save' => function ($url, $model, $key) {
                        return Html::a('<i class="glyphicon glyphicon-download"></i> ' . Yii::t('app', 'Save'), $url, [
                            'class'                 => 'btn btn-xs btn-success btn-translation-save',
                            'action'                => 'translation-save',
                            'title'                 => Yii::t('app', 'Save'),
                            'before-send-title'     => Yii::t('app', 'Request sent'),
                            'before-send-message'   => Yii::t('app', 'Please, wait...'),
                            'success-title'         => Yii::t('app', 'Server Response'),
                            'success-message'       => Yii::t('app', 'Message successfully saved.'),
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        if ( strstr($model->message, '@@') ) {
                            return '<span class="btn-ajax-wrap">' . Html::a('<i class="glyphicon glyphicon-refresh"></i>', str_replace('delete', 'restore', $url), [
                                'class'                 => 'btn btn-xs btn-info btn-ajax',
                                'action'                => 'translation-restore',
//                                'title'                 => Yii::t('app', 'Restore'),
//                                'data-confirm'          => Yii::t('app', 'Are you sure you want to restore this item?'),
                                'data-toggle'           => 'confirmation',
                                'data-singleton'        => 'true',
                                'data-placement'        => 'top',
                                'data-btn-ok-lable'     => Yii::t('app', 'Yes'),
                                'data-btn-ok-class'     => 'btn-xs btn-success',
                                'data-btn-cancel'       => Yii::t('app', 'No'),
                                'data-btn-cancel-class' => 'btn-xs btn-warning',
                                'data-popout'           => 'true',
                                'before-send-title'     => Yii::t('app', 'Request sent'),
                                'before-send-message'   => Yii::t('app', 'Please, wait...'),
                                'success-title'         => Yii::t('app', 'Server Response'),
                                'success-message'       => Yii::t('app', 'Message successfully restored.'),
                            ]) . '</span>';
                        } else {
                            return '<span class="btn-ajax-wrap">' . Html::a('<i class="glyphicon glyphicon-trash"></i>', $url, [
                                'class'                 => 'btn btn-xs btn-danger btn-ajax',
                                'action'                => 'translation-delete',
//                                'title'                 => Yii::t('app', 'Delete'),
//                                'data-confirm'          => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'data-toggle'           => 'confirmation',
                                'data-singleton'        => 'true',
                                'data-placement'        => 'top',
                                'data-btn-ok-lable'     => Yii::t('app', 'Yes'),
                                'data-btn-ok-class'     => 'btn-xs btn-success',
                                'data-btn-cancel'       => Yii::t('app', 'No'),
                                'data-btn-cancel-class' => 'btn-xs btn-warning',
                                'data-popout'           => 'true',
                                'before-send-title'     => Yii::t('app', 'Request sent'),
                                'before-send-message'   => Yii::t('app', 'Please, wait...'),
                                'success-title'         => Yii::t('app', 'Server Response'),
                                'success-message'       => Yii::t('app', 'Message successfully deleted.'),
                            ]) . '</span>';
                        }
                    },
                ],
            ],
            // --------------------------- LOCATIONS ---------------------------
            [
                'attribute' => 'location',
                'value' => function ($model, $key, $index, $dataColumn) {
                    return $model->location;
                },
                'enableSorting' => false,
                'visible' => false,
            ],
        ],
    ]); ?>
</div>
<?php echo ScrollToTop::widget();
