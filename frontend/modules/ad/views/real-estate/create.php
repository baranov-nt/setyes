<?php
use yii\bootstrap\Nav;
use yii\widgets\Pjax;
use common\widgets\Chosen\ChosenAsset;
use common\widgets\FontAwesome\AssetBundle;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $modelAdRealEstate common\models\AdRealEstate */
/* @var $realEstateProperty common\models\AdRealEstateReference */
/* @var $pjaxUrl string */

$this->title = Yii::t('app', 'Create Ad Real Estate');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Real Estates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?php
        echo \common\widgets\ImageLoad\ImageLoadWidget::widget([
            'modelName' => 'AdRealEstate',
            'id' => 'load-image',                                       // суффикс ID для основных форм виджета
            'object_id' => $modelAdRealEstate->id,                          // ID объекта, к которому привязаны изображения
            'imagesObject' => $modelAdRealEstate->imagesOfObjects,          // объект с загруженными для модели изображениями
            'images_num' => 6,                 // максимальное количество изображений
            'images_label' => $modelAdRealEstate->images_label,             // максимальное количество изображений
            'images_temp' => 0,       // указываем временной изображение или нет
            'imageSmallWidth' => 360,                       // ширина миниатюры
            'imageSmallHeight' => 200,                      // высота миниатюры
            'headerModal' => 'Загрузить изображение товара',                        // заголовок в модальном окне
            'sizeModal' => 'modal-md',                                  // размер модального окна
            'baseUrl' => '/images/',                        // основной путь к изображениям
            'imagePath' => 'imagesApp/images/',   // путь, куда будут записыватся изображения
            'noImage' => 'imagesApp/noImage.png',                 // картинка, если изображение отсутствует
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
                //'width' => 160,                             // ширина
                //'height' => 200                             // высота
            ],
            'canvasData' => [                               // начальные настройки холста
                //'width' => 500,                             // ширина
                //'height' => 500                             // высота
            ]]);
        ?>
    </div>
</div>

<?php
Pjax::begin([
    'enablePushState' => false,
]);
AssetBundle::register($this);
ChosenAsset::register($this);
MaskedInput::widget([
    'name' => 'masked-input_init',
    'clientOptions' => [
        'alias' => 'decimal',
    ],
]);
//
echo Nav::widget([
    'items' => $modelAdRealEstate->realEstatePropertyList,
    'activateParents' => true,
    'encodeLabels' => false,
    'options' => [
        'class' => 'nav nav-tabs',
    ]
]);
?>


<?php if($modelAdRealEstate->scenario != 'default'):
    ?>
    <?= $this->render('_form', [
        'modelAdRealEstate' => $modelAdRealEstate,
        'pjaxUrl' => $pjaxUrl
    ]);

    ?>
<?php
endif;
?>

<?php
Pjax::end();
?>

