<?php
use common\widgets\StepsNavigation\StepsNavigation;
use yii\helpers\Url;
use common\widgets\ImageLoad\ImageLoadWidget;
use yii\bootstrap\Html;
use yii\bootstrap\Carousel;

/* @var $this yii\web\View */
/* @var $modelAdRealEstate common\models\AdRealEstate */
/* @var $user common\models\User */

$this->title = Yii::t('app', 'Step 3').': '.Yii::t('references', $modelAdRealEstate->dealType->reference_name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Real Estates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->user->identity;
?>
<div class="container" style="margin-top: 0 !important; padding-top: 0 !important;">
    <div class="col-md-12 text-center">
        <?php
        echo StepsNavigation::widget([
            'targetStep1' => '#confirm-step1',
            'urlStep1' => Url::to(['/ad/default/index', 'id' => $modelAdRealEstate->id]),
            'urlStep2' => Url::to(['/ad/real-estate/update', 'id' => $modelAdRealEstate->id]),
            'urlStep3' => Url::to(['/ad/real-estate/view', 'id' => $modelAdRealEstate->id]),
            'urlStep4' => Url::to(['/#']),
            'titleStep1' => Yii::t('app', 'Step 1'),
            'titleStep2' => Yii::t('app', 'Step 2'),
            'titleStep3' => Yii::t('app', 'Step 3'),
            'titleStep4' => Yii::t('app', 'Complite'),
            'headerStep1' => Yii::t('app', 'Select Category'),
            'headerStep2' => Yii::t('app', 'Select the type of property and fill out a simple form.'),
            'headerStep3' => Yii::t('app', 'Add photos'),
            'headerStep4' => Yii::t('app', 'Post the ad'),
            'contentStep1' => Yii::t('app', 'Select Category: content'),
            'contentStep2' => Yii::t('app', 'Fill in the form: content'),
            'contentStep3' => Yii::t('app', 'Add images: content'),
            'contentStep4' => Yii::t('app', 'Post the ad: content'),
            'classLinkStep1' => '',
            'classLinkStep2' => '',
            'classLinkStep3' => '',
            'classLinkStep4' => 'active',
            'classContentStep1' => 'tab-pane',
            'classContentStep2' => 'tab-pane',
            'classContentStep3' => 'tab-pane',
            'classContentStep4' => 'tab-pane active',
        ]);
        //
        ?>
    </div>
    <div class="col-md-3 alert alert-success"  style="border: 1px solid #cccccc; border-radius: 3px; box-shadow: 0.2em 0.2em 3px rgba(122,122,122,0.5);">
        <div class="row">
            <div class="col-xs-12">
                <button class="btn btn-sm btn-success" style="outline: none; border-radius: 3px; margin: 0 0 0 0 !important; float: right;"><i class="fa fa-plus-circle fa-lg" style=""></i></button>
                <h4 style="padding: 0; margin: 0;"><?= Html::a(Yii::t('references', $modelAdRealEstate->dealType->reference_name), Url::to(['/#']), ['style' => 'text-transform: uppercase;']) // операция ?></h4>
            </div>
            <div class="col-xs-12" style="padding-top: 10px;">
                <p style="text-align: justify;"><?= $modelAdRealEstate->place_city.', '.$modelAdRealEstate->place_street.', '.$modelAdRealEstate->place_house ?></p>
            </div>
            <div class="col-xs-12" style="padding-bottom: 10px;">
                <?php
                if(count($modelAdRealEstate->imagesOfObjects) > 1):
                    foreach($modelAdRealEstate->imagesOfObjects as $one):
                        $items[] = [
                            'content' => Html::img('/images/'.$one->image->path_small_image, [
                                'style' => 'width: 100%; border-radius: 3px;'
                            ]),
                            'options' => [
                                'style' => 'width:100%;' // set the width of the container if you like
                            ],
                            'active' => false
                        ];
                    endforeach;
                    echo Carousel::widget([
                        'items' => $items,
                        'options' => [
                            'data-interval' => 0,
                            'class' => 'slide',
                            'style' => 'width:100%;' // set the width of the container if you like
                        ],
                        'controls' => ['&lsaquo;', '&rsaquo;'],     // Стрелочки вперед - назад
                        //'controls' => ['<', '>'],                     // Стрелочки вперед - назад
                        'showIndicators' => true,                   // отображать индикаторы (кругляшки)

                    ]);
                else:
                    /* Если одно изоражение */
                    foreach($modelAdRealEstate->imagesOfObjects as $one):
                        echo Html::img('/images/'.$one->image->path_small_image, [
                            'style' => 'width: 100%'
                        ]);
                    endforeach;
                endif;
                ?>
            </div>
            <div class="col-xs-12">
                <?= $modelAdRealEstate->contentList ?>
            </div>
            <div class="col-xs-12">
                <i class="fa fa-mobile fa-3x" style="outline: none; border-radius: 3px; float: left; margin-right: 10px;"></i>
                <h5 style="margin-top: 17px !important;"><?= $user->phone ?></h5>
            </div>
            <div class="col-xs-12">
                <i class="fa fa-envelope-o fa-2x" style="outline: none; border-radius: 3px; float: left; margin-right: 10px;"></i>
                <h5 style="margin-top: 8px !important;"><?= $user->email ?></h5>
            </div>
            <div class="col-xs-12">
                <?= Html::button('Быстрый просмотр', ['class' => 'btn btn-success', 'style' => 'width: 100%;']) ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">

        <?php //d($modelAdRealEstate->columnList) ?>
    </div>

</div>


