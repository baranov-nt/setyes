<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\ChosenAsset;
use common\widgets\FontAwesome\AssetBundle;
use justinvoelker\awesomebootstrapcheckbox\ActiveField;
use yii\widgets\MaskedInput;
use common\widgets\GooglePlacesAutoComplete\GooglePlacesAutoComplete;
use common\widgets\ImageLoad\ImageLoadWidget;

AssetBundle::register($this);
ChosenAsset::register($this);
/* @var $this yii\web\View */
/* @var $modelAdRealEstate common\models\AdRealEstate */
/* @var $user common\models\User */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $key int */
/* @var $pjaxUrl string */

$user = Yii::$app->user->identity;

MaskedInput::widget([
    'name' => 'masked-input_init',
    'clientOptions' => [
        'alias' => 'decimal',
    ],
]);
?>

<div class="row">
    <div class="col-md-12">
        <?php
        echo ImageLoadWidget::widget([
            'modelName' => 'Product',
            'id' => 'load-image',                                       // суффикс ID для основных форм виджета
            'object_id' => $modelAdRealEstate->id,                          // ID объекта, к которому привязаны изображения
            'imagesObject' => $modelAdRealEstate->adCategories->imagesOfObjects,          // объект с загруженными для модели изображениями
            'images_num' => $user->userPrivilege->images_num,                 // максимальное количество изображений
            'images_label' => $modelAdRealEstate->adCategories->category_id,             // максимальное количество изображений
            'images_temp' => 0,       // указываем временной изображение или нет
            'imageSmallWidth' => 360,                       // ширина миниатюры
            'imageSmallHeight' => 200,                      // высота миниатюры
            'headerModal' => 'Загрузить изображение товара',                        // заголовок в модальном окне
            'sizeModal' => 'modal-md',                                  // размер модального окна
            'baseUrl' => '/images/',                        // основной путь к изображениям
            'imagePath' => 'product/images/',   // путь, куда будут записыватся изображения
            'noImage' => 'product/noImage.png',                 // картинка, если изображение отсутствует
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
<div class="ad-real-estate-form">
    <?php $form = ActiveForm::begin([
        'fieldClass' => ActiveField::className(),
        'id' => 'ad_form',
    ]); ?>

    <?= $form->field($modelAdRealEstate, 'property')->hiddenInput()->label(false) ?>

    <?= $form->field($modelAdRealEstate, 'deal_type')->dropDownList($modelAdRealEstate->realEstateOperationTypeList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
        'onChange' => '
        $.pjax({
            type: "POST",
            url: "'.$pjaxUrl.'",
            data: jQuery("#ad_form").serialize(),
            container: "#w0",
            push: false
        })
        '
    ]) ?>

    <?php
    /** Город доступен всем операциям */
    ?>
    <?php
    if($modelAdRealEstate->scenario != 'rooms' && $modelAdRealEstate->scenario != 'apartments' && $modelAdRealEstate->scenario != 'houses' && $modelAdRealEstate->scenario != 'land'
        && $modelAdRealEstate->scenario != 'garages' && $modelAdRealEstate->scenario != 'propertyAbroad' && $modelAdRealEstate->scenario != 'comercial'):
        ?>
        <?= $form->field($modelAdRealEstate, 'place_city')->widget(GooglePlacesAutoComplete::className(), [
        'name' => 'place-city',
        'value' => '',
    ]); ?>
        <?= $form->field($modelAdRealEstate, 'place_city_validate')->hiddenInput(['value' => '1'])->label(false); ?>
        <?php
    endif;
    ?>

    <?php
    /** Улица доступна только сценариям
     * 'sellingGarage' 'rentGarage' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'sellingGarage' || $modelAdRealEstate->scenario == 'rentGarage' || $modelAdRealEstate->scenario == 'buyGarage' || $modelAdRealEstate->scenario == 'buyGarage'):
        ?>
        <?= $form->field($modelAdRealEstate, 'place_street'); ?>
        <?= $form->field($modelAdRealEstate, 'place_address')->hiddenInput(['value' => '1'])->label(false); ?>
        <?php
    endif;
    ?>

    <?php
    /** Полный адрес доступен только сценариям
     * 'sellingRoom'  'rentARoom' 'sellingApatrment' 'rentApatrment' 'sellingHouse' 'rentHouse' 'sellingComercial' 'rentComercial' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
        || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
        || $modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse'
        || $modelAdRealEstate->scenario == 'sellingComercial' || $modelAdRealEstate->scenario == 'rentComercial'
    ):
        ?>
        <?= $form->field($modelAdRealEstate, 'place_street'); ?>
        <?= $form->field($modelAdRealEstate, 'place_house'); ?>
        <?= $form->field($modelAdRealEstate, 'place_address')->hiddenInput(['value' => '1'])->label(false); ?>
        <?php
    endif;
    ?>

    <?php
    /** Тип недвижемости доступен всем операциям, кроме сценариев
     * 'sellingRoom'  'rentARoom' 'buyRoom' 'rentingARoom' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
        || $modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse' || $modelAdRealEstate->scenario == 'buyHouse' || $modelAdRealEstate->scenario == 'rentingHouse'
        || $modelAdRealEstate->scenario == 'sellingLand' || $modelAdRealEstate->scenario == 'buyLand'
        || $modelAdRealEstate->scenario == 'sellingGarage' || $modelAdRealEstate->scenario == 'rentGarage' || $modelAdRealEstate->scenario == 'buyGarage' || $modelAdRealEstate->scenario == 'rentingGarage'
        || $modelAdRealEstate->scenario == 'sellingPropertyAbroad' || $modelAdRealEstate->scenario == 'buyPropertyAbroad'
        || $modelAdRealEstate->scenario == 'sellingComercial' || $modelAdRealEstate->scenario == 'rentComercial' || $modelAdRealEstate->scenario == 'buyComercial' || $modelAdRealEstate->scenario == 'rentingComercial'
    ):
        ?>
        <?= $form->field($modelAdRealEstate, 'type_of_property')->dropDownList($modelAdRealEstate->realEstatePropertyTypeList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Количество комнат доступно для сценариев
     * 'sellingRoom'  'rentARoom' 'sellingApatrment' 'rentApatrment' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
        || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'):
    ?>
    <?= $form->field($modelAdRealEstate, 'rooms_in_the_apartment')->dropDownList($modelAdRealEstate->realEstateRoomsInApartmentList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
        'onChange' => '
        '
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Материал здания доступен для сценариев
     * 'sellingRoom'  'rentARoom' 'sellingApatrment' 'rentApatrment' 'sellingHouse' 'rentHouse' 'sellingGarage' 'rentGarage'
     * 'sellingPropertyAbroad' 'sellingComercial' 'rentComercial' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
        || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
        || $modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse'
        || $modelAdRealEstate->scenario == 'sellingGarage' || $modelAdRealEstate->scenario == 'rentGarage'
        || $modelAdRealEstate->scenario == 'sellingPropertyAbroad'
        || $modelAdRealEstate->scenario == 'sellingComercial' || $modelAdRealEstate->scenario == 'rentComercial'
    ):
        ?>
        <?= $form->field($modelAdRealEstate, 'material_housing')->dropDownList($modelAdRealEstate->realEstateMaterialHousingList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Этаж на котором находится недвижемость доступен для сценариев
     * 'sellingRoom'  'rentARoom' 'sellingApatrment' 'rentApatrment' 'sellingComercial' 'rentComercial' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
        || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
        || $modelAdRealEstate->scenario == 'sellingComercial' || $modelAdRealEstate->scenario == 'rentComercial'
    ):
        ?>
        <?= $form->field($modelAdRealEstate, 'floor')->dropDownList($modelAdRealEstate->realEstateFloorsList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Этажей в доме с недвижемостью (кроме операций с домами) доступен для сценариев
     * 'sellingRoom'  'rentARoom' 'sellingApatrment' 'rentApatrment' 'sellingPropertyAbroad' 'sellingComercial' 'rentComercial' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
        || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
        || $modelAdRealEstate->scenario == 'sellingComercial' || $modelAdRealEstate->scenario == 'rentComercial'
    ):
        ?>
        <?= $form->field($modelAdRealEstate, 'floors_in_the_house')->dropDownList($modelAdRealEstate->realEstateFloorsInBuildingList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Этажей в доме с недвижемостью (для операций с домами и недвижемостью за рубежом) доступен для сценариев
     * 'sellingHouse' 'rentHouse' 'sellingPropertyAbroad' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse' || $modelAdRealEstate->scenario == 'sellingPropertyAbroad'):
        ?>
        <?= $form->field($modelAdRealEstate, 'floors_in_the_house')->dropDownList($modelAdRealEstate->realEstateFloorsInHouseList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Площать ведвижемости доступен для сценариев
     * 'sellingRoom'  'rentARoom' 'sellingApatrment' 'rentApatrment' 'sellingHouse' 'rentHouse' 'sellingGarage' 'rentGarage'
     * 'sellingPropertyAbroad' 'sellingComercial' 'rentComercial' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
        || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
        || $modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse'
        || $modelAdRealEstate->scenario == 'sellingGarage' || $modelAdRealEstate->scenario == 'rentGarage'
        || $modelAdRealEstate->scenario == 'sellingPropertyAbroad'
        || $modelAdRealEstate->scenario == 'sellingComercial' || $modelAdRealEstate->scenario == 'rentComercial'
    ):
    ?>
    <?= $form->field($modelAdRealEstate, 'area_of_property')->textInput(['style' => 'text-align: right !important;'])->label($modelAdRealEstate->getAttributeLabel('area_of_property').' ('.$modelAdRealEstate->realEstateMeasurementOfPropertyName.')') ?>
        <?php
    endif;
    ?>

    <?php
    /** Площать земли доступен для сценариев
     * 'sellingLand' 'sellingHouse' 'rentHouse' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse' || $modelAdRealEstate->scenario == 'sellingLand'):
        ?>
        <?= $form->field($modelAdRealEstate, 'area_of_land')->textInput(['style' => 'text-align: right !important;']) ?>
        <?= $form->field($modelAdRealEstate, 'measurement_of_land')->dropDownList($modelAdRealEstate->realEstateMeasurementOfLandName, [
        'class'  => 'form-control chosen-select',
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Срок аренды доступена для сценариев
     * 'rentARoom' 'rentApatrment' 'rentHouse' 'rentGarage' 'rentComercial' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentApatrment' || $modelAdRealEstate->scenario == 'rentHouse'
        || $modelAdRealEstate->scenario == 'rentGarage' || $modelAdRealEstate->scenario == 'rentComercial'):
        ?>
    <?= $form->field($modelAdRealEstate, 'lease_term')->dropDownList($modelAdRealEstate->realEstateLeaseTermList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Цена доступена всем операциям */
    ?>
    <?php
    if($modelAdRealEstate->scenario != 'rooms' && $modelAdRealEstate->scenario != 'apartments' && $modelAdRealEstate->scenario != 'houses' && $modelAdRealEstate->scenario != 'land'
        && $modelAdRealEstate->scenario != 'garages' && $modelAdRealEstate->scenario != 'propertyAbroad' && $modelAdRealEstate->scenario != 'comercial'):
        ?>
    <?php
    echo $form->field($modelAdRealEstate, 'price')->widget(MaskedInput::className(), [
        'name' => 'masked-input',
        'clientOptions' => [
            'alias' => 'decimal',
            'digits' => 2,
            'digitsOptional' => false,
            'radixPoint' => '.',
            //'groupSeparator' => ',',
            'autoGroup' => false,
            'removeMaskOnSubmit' => true,
            'placeholder' =>  '0'
        ],
    ])->label($modelAdRealEstate->getAttributeLabel('price').' ('.$modelAdRealEstate->realEstateCurrency.') '.$modelAdRealEstate->getRealEstatePriceForThePeriod($modelAdRealEstate->lease_term)); ?>
        <?php
    endif;
    ?>

    <?php
    /** Цена за период доступена для сценариев
     * 'rentARoom' 'rentApatrment' 'rentHouse' 'rentGarage' 'rentComercial' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentApatrment' || $modelAdRealEstate->scenario == 'rentHouse'
        || $modelAdRealEstate->scenario == 'rentGarage' || $modelAdRealEstate->scenario == 'rentComercial'):
        ?>
    <?= $form->field($modelAdRealEstate, 'price_for_the_period')->dropDownList($modelAdRealEstate->realEstatePricePeriodList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Необходимая мебель доступена для сценариев
     * 'rentARoom' 'rentApatrment' 'rentHouse' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentApatrment' || $modelAdRealEstate->scenario == 'rentHouse'):
        ?>
    <?= $form->field($modelAdRealEstate, 'necessary_furniture')->dropDownList($modelAdRealEstate->realEstateNecessaryFurnitureList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Интернет доступен для сценариев
     * 'rentARoom' 'rentApatrment' 'rentHouse' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentApatrment' || $modelAdRealEstate->scenario == 'rentHouse'):
    ?>
    <?= $form->field($modelAdRealEstate, 'internet')->dropDownList($modelAdRealEstate->realEstateInternetList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Домашние животные доступен для сценариев
     * 'rentARoom' 'rentApatrment' 'rentHouse' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentApatrment' || $modelAdRealEstate->scenario == 'rentHouse'):
        ?>
    <?= $form->field($modelAdRealEstate, 'pets_allowed')->dropDownList($modelAdRealEstate->realEstatePetsAllowedList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Состояние доступено для сценариев
     * 'sellingRoom'  'rentARoom' 'sellingApatrment' 'rentApatrment' 'sellingHouse' 'rentHouse' 'sellingGarage' 'rentGarage'
     * 'sellingPropertyAbroad' 'sellingComercial' 'rentComercial' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
        || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
        || $modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse'
        || $modelAdRealEstate->scenario == 'sellingGarage' || $modelAdRealEstate->scenario == 'rentGarage'
        || $modelAdRealEstate->scenario == 'sellingPropertyAbroad'
        || $modelAdRealEstate->scenario == 'sellingComercial' || $modelAdRealEstate->scenario == 'rentComercial'
    ):
        ?>
    <?= $form->field($modelAdRealEstate, 'condition')->dropDownList($modelAdRealEstate->realEstateConditionList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Бытовая техника доступена для сценариев
     * 'rentARoom' 'rentApatrment' 'rentHouse' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentApatrment' || $modelAdRealEstate->scenario == 'rentHouse'):
        ?>
    <?php echo $form->field($modelAdRealEstate, 'appliances')->checkboxList($modelAdRealEstate->realEstateAppliancesList,
        [
            'itemOptions' => [
                'disabled' => false,
                'divOptions' => ['class' => 'checkbox checkbox-warning']
            ]]);
    ?>
        <?php
    endif;
    ?>

    <?php /*echo $form->field($modelAdRealEstate, 'appliances')->inline()->checkboxList($modelAdRealEstate->realEstateAppliancesList,
        [
            'itemOptions' => [
                'disabled' => false,
                'divOptions' => ['class' => 'checkbox checkbox-warning checkbox-inline']
            ]]);*/
    ?>

    <?= $form->field($modelAdRealEstate, 'scenario')->hiddenInput(['value' => $modelAdRealEstate->scenario])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($modelAdRealEstate->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            [
                'class' => $modelAdRealEstate->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                //'disabled' => true
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
