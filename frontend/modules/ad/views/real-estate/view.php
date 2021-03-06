<?php

use yii\widgets\DetailView;
use common\widgets\StepsNavigation\StepsNavigation;
use yii\helpers\Url;
use common\widgets\ImageLoad\ImageLoadWidget;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $modelAdRealEstate common\models\AdRealEstate */
/* @var $user common\models\User */
$user = Yii::$app->user->identity;

$this->title = Yii::t('app', 'Step 3').': '.Yii::t('app', 'Add photos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Real Estates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container" style="margin-top: 0 !important; padding-top: 0 !important;">
    <div class="col-md-12 text-center">
        <?php
        echo StepsNavigation::widget([
            'targetStep1' => '#confirm-step1',
            'urlStep1' => Url::to(['/ad/default/index', 'id' => $modelAdRealEstate->adCategory->adMain->id]),
            'urlStep2' => Url::to(['/ad/real-estate/update', 'id' => $modelAdRealEstate->id]),
            'urlStep3' => Url::to(['/#']),
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
            'classLinkStep3' => 'active',
            'classLinkStep4' => 'disabled',
            'classContentStep1' => 'tab-pane',
            'classContentStep2' => 'tab-pane',
            'classContentStep3' => 'tab-pane active',
            'classContentStep4' => 'tab-pane',
        ]);
        //
        ?>
    </div>
        <h1 class="text-center" style="margin-bottom: 40px;"><?= Html::encode($this->title) ?></h1>
    <div class="col-md-6" style="margin-top: 0 !important; padding-top: 0 !important; padding-bottom: 20px;">
        <div class="row">
            <div class="col-md-12">
                <?php
                if($modelAdRealEstate->model_scenario == 'sellingRoom' || $modelAdRealEstate->model_scenario == 'rentARoom'
                    || $modelAdRealEstate->model_scenario == 'sellingApatrment' || $modelAdRealEstate->model_scenario == 'rentApatrment'
                    || $modelAdRealEstate->model_scenario == 'sellingHouse' || $modelAdRealEstate->model_scenario == 'rentHouse'
                    || $modelAdRealEstate->model_scenario == 'sellingLand'
                    || $modelAdRealEstate->model_scenario == 'sellingGarage' || $modelAdRealEstate->model_scenario == 'rentGarage'
                    || $modelAdRealEstate->model_scenario == 'sellingComercial' || $modelAdRealEstate->model_scenario == 'rentComercial'):?>
                    <?php
                    echo ImageLoadWidget::widget([
                        'modelName' => 'AdRealEstate',
                        'id' => 'load-image',                                       // суффикс ID для основных форм виджета
                        'object_id' => $modelAdRealEstate->id,                          // ID объекта, к которому привязаны изображения
                        'imagesObject' => $modelAdRealEstate->imagesOfObjects,          // объект с загруженными для модели изображениями
                        'images_num' => $user->userPrivilege->images_num,                 // максимальное количество изображений
                        'images_label' => $modelAdRealEstate->images_label,             // максимальное количество изображений
                        'images_temp' => 0,       // указываем временной изображение или нет
                        'imageSmallWidth' => 480,                       // ширина миниатюры
                        'imageSmallHeight' => 270,                      // высота миниатюры
                        'headerModal' => 'Загрузить изображение товара',                        // заголовок в модальном окне
                        'sizeModal' => 'modal-md',                                  // размер модального окна
                        'baseUrl' => '/images/',                        // основной путь к изображениям
                        'imagePath' => 'imagesApp/'.$modelAdRealEstate->model_scenario.'/'.$modelAdRealEstate->subDir.'/',   // путь, куда будут записыватся изображения
                        'noImage' => 'imagesApp/noImage_'.Yii::$app->language.'.png',                 // картинка, если изображение отсутствует
                        'classesWidget' => [
                            'imageClass' => 'imageProduct',
                            'buttonDeleteClass' => 'btn btn-xs btn-danger btn-imageDeleteProduct glyphicon glyphicon-trash glyphicon',
                            'imageContainerClass' => 'imageContainerProduct',
                            'formImagesContainerClass' => 'formImageContainerProduct',
                        ],
                        'pluginOptions' => [                            // настройки плагина
                            'aspectRatio' => 16/9,                      // установите соотношение сторон рамки обрезки. По умолчанию свободное отношение.
                            'strict' => true,                           // true - рамка не может вызодить за холст, false - может
                            'guides' => true,                           // показывать пунктирные линии в рамке
                            'center' => true,                           // показывать центр в рамке изображения изображения
                            'autoCrop' => true,                         // показывать рамку обрезки при загрузке
                            'autoCropArea' => 0.5,                      // площидь рамки на холсте изображения при autoCrop (1 = 100% - 0 - 0%)
                            'dragCrop' => true,                         // создание новой рамки при клики в свободное место хоста (false - нельзя)
                            'movable' => true,                          // перемещать изображение холста (false - нельзя)
                            'rotatable' => true,                        // позволяет вращать изображение
                            'scalable' => true,                         // мастабирование изображения
                            'zoomable' => true,
                            'preview' => '.img-preview',                // класс превью
                        ],
                        'cropBoxData' => [                              // начальные настройки рамки // cropBoxData = { left: 10, top: 10, width: 160, height:200 }
                            'left' => 10,                               // смещение слева
                            'top' => 10,                                // смещение вниз
                            'width' => 480,                             // ширина
                            'height' => 270                             // высота
                        ],
                        'canvasData' => [                               // начальные настройки холста
                            //'width' => 500,                             // ширина
                            //'height' => 500                             // высота
                        ]]);
                    ?>
                    <?php
                else:
                    ?>
                    <h4><?= Yii::t('app', 'For this advertisement you can not add photos.') ?></h4>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="ad-real-estate-view">
            <?php
            echo DetailView::widget([
                'model' => $modelAdRealEstate,
                'attributes' => $modelAdRealEstate->columnList,
            ]) ?>
        </div>
    </div>
    <div class="col-md-12 text-center">
        <?= Html::a(Yii::t('app', 'Continue'), ['/ad/view/complite', 'id' => $modelAdRealEstate->adCategory->adMain->id], ['class' => 'btn btn-primary']) ?>
    </div>
</div>

