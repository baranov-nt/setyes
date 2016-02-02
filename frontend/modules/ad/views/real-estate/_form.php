<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\ChosenAsset;
use common\widgets\FontAwesome\AssetBundle;
use justinvoelker\awesomebootstrapcheckbox\ActiveField;
use yii\widgets\MaskedInput;
use common\widgets\GooglePlacesAutoComplete\GooglePlacesAutoComplete;

AssetBundle::register($this);
ChosenAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\AdRealEstate */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $key int */
/* @var $pjaxUrl string */
MaskedInput::widget([
    'name' => 'masked-input_init',
    'clientOptions' => [
        'alias' => 'decimal',
    ],
]);
?>

<div class="ad-real-estate-form">

    <?php $form = ActiveForm::begin([
        'fieldClass' => ActiveField::className(),
        'id' => 'ad_form',
    ]); ?>

    <?= $form->field($model, 'property')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'deal_type')->dropDownList($model->realEstateOperationTypeList, [
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
    if($model->scenario != 'rooms' && $model->scenario != 'apartments' && $model->scenario != 'houses' && $model->scenario != 'land'
        && $model->scenario != 'garages' && $model->scenario != 'propertyAbroad' && $model->scenario != 'comercial'):
        ?>
        <?= $form->field($model, 'place_city')->widget(GooglePlacesAutoComplete::className(), [
        'name' => 'place-city',
        'value' => '',
    ]); ?>
        <?= $form->field($model, 'place_city_validate')->hiddenInput(['value' => '1'])->label(false); ?>
        <?php
    endif;
    ?>

    <?php
    /** Улица доступна только сценариям
     * 'sellingGarage' 'rentGarage' */
    ?>
    <?php
    if($model->scenario == 'sellingGarage' || $model->scenario == 'rentGarage' || $model->scenario == 'buyGarage' || $model->scenario == 'buyGarage'):
        ?>
        <?= $form->field($model, 'place_street'); ?>
        <?= $form->field($model, 'place_address')->hiddenInput(['value' => '1'])->label(false); ?>
        <?php
    endif;
    ?>

    <?php
    /** Полный адрес доступен только сценариям
     * 'sellingRoom'  'rentARoom' 'sellingApatrment' 'rentApatrment' 'sellingHouse' 'rentHouse' 'sellingComercial' 'rentComercial' */
    ?>
    <?php
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom'
        || $model->scenario == 'sellingApatrment' || $model->scenario == 'rentApatrment'
        || $model->scenario == 'sellingHouse' || $model->scenario == 'rentHouse'
        || $model->scenario == 'sellingComercial' || $model->scenario == 'rentComercial'
    ):
        ?>
        <?= $form->field($model, 'place_street'); ?>
        <?= $form->field($model, 'place_house'); ?>
        <?= $form->field($model, 'place_address')->hiddenInput(['value' => '1'])->label(false); ?>
        <?php
    endif;
    ?>

    <?php
    /** Тип недвижемости доступен всем операциям, кроме сценариев
     * 'sellingRoom'  'rentARoom' 'buyRoom' 'rentingARoom' */
    ?>
    <?php
    if($model->scenario == 'sellingApatrment' || $model->scenario == 'rentApatrment'
        || $model->scenario == 'sellingHouse' || $model->scenario == 'rentHouse' || $model->scenario == 'buyHouse' || $model->scenario == 'rentingHouse'
        || $model->scenario == 'sellingLand' || $model->scenario == 'buyLand'
        || $model->scenario == 'sellingGarage' || $model->scenario == 'rentGarage' || $model->scenario == 'buyGarage' || $model->scenario == 'rentingGarage'
        || $model->scenario == 'sellingPropertyAbroad' || $model->scenario == 'buyPropertyAbroad'
        || $model->scenario == 'sellingComercial' || $model->scenario == 'rentComercial' || $model->scenario == 'buyComercial' || $model->scenario == 'rentingComercial'
    ):
        ?>
        <?= $form->field($model, 'type_of_property')->dropDownList($model->realEstatePropertyTypeList, [
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
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom'
        || $model->scenario == 'sellingApatrment' || $model->scenario == 'rentApatrment'):
    ?>
    <?= $form->field($model, 'rooms_in_the_apartment')->dropDownList($model->realEstateRoomsInApartmentList, [
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
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom'
        || $model->scenario == 'sellingApatrment' || $model->scenario == 'rentApatrment'
        || $model->scenario == 'sellingHouse' || $model->scenario == 'rentHouse'
        || $model->scenario == 'sellingGarage' || $model->scenario == 'rentGarage'
        || $model->scenario == 'sellingPropertyAbroad'
        || $model->scenario == 'sellingComercial' || $model->scenario == 'rentComercial'
    ):
        ?>
        <?= $form->field($model, 'material_housing')->dropDownList($model->realEstateMaterialHousingList, [
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
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom'
        || $model->scenario == 'sellingApatrment' || $model->scenario == 'rentApatrment'
        || $model->scenario == 'sellingComercial' || $model->scenario == 'rentComercial'
    ):
        ?>
        <?= $form->field($model, 'floor')->dropDownList($model->realEstateFloorsList, [
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
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom'
        || $model->scenario == 'sellingApatrment' || $model->scenario == 'rentApatrment'
        || $model->scenario == 'sellingPropertyAbroad'
        || $model->scenario == 'sellingComercial' || $model->scenario == 'rentComercial'
    ):
        ?>
        <?= $form->field($model, 'floors_in_the_house')->dropDownList($model->realEstateFloorsInBuildingList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Этажей в доме с недвижемостью (для операций с домами) доступен для сценариев
     * 'sellingHouse' 'rentHouse' */
    ?>
    <?php
    if($model->scenario == 'sellingHouse' || $model->scenario == 'rentHouse'):
        ?>
        <?= $form->field($model, 'floors_in_the_house')->dropDownList($model->realEstateFloorsInHouseList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom'
        || $model->scenario == 'sellingApatrment' || $model->scenario == 'rentApatrment'):
    ?>
    <?= $form->field($model, 'area_of_property')->textInput()->label($model->getAttributeLabel('area_of_property').' ('.$model->realEstateSystemMeasureName.')') ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'sellingHouse' || $model->scenario == 'rentHouse' || $model->scenario == 'sellingLand'):
        ?>
        <?= $form->field($model, 'area_of_land')->textInput() ?>
        <?= $form->field($model, 'system_measure')->dropDownList($model->realEstateLeaseTermList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'rentARoom' || $model->scenario == 'rentingARoom'
        || $model->scenario == 'rentApatrment' || $model->scenario == 'rentingApatrment'):
        ?>
    <?= $form->field($model, 'lease_term')->dropDownList($model->realEstateLeaseTermList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom' || $model->scenario == 'buyRoom' || $model->scenario == 'rentingARoom'
        || $model->scenario == 'sellingApatrment' || $model->scenario == 'rentApatrment' || $model->scenario == 'buyApatrment' || $model->scenario == 'rentingApatrment'):
    ?>
    <?php
    echo $form->field($model, 'price')->widget(MaskedInput::className(), [
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
    ])->label($model->getAttributeLabel('price').' ('.$model->realEstateCurrency.') '.$model->getRealEstatePriceForThePeriod($model->lease_term)); ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'rentARoom' || $model->scenario == 'rentingARoom'
        || $model->scenario == 'rentApatrment' || $model->scenario == 'rentingApatrment'):
    ?>
    <?= $form->field($model, 'price_for_the_period')->dropDownList($model->realEstatePricePeriodList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'rentARoom' || $model->scenario == 'rentApatrment'):
    ?>
    <?= $form->field($model, 'necessary_furniture')->dropDownList($model->realEstateNecessaryFurnitureList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'rentARoom' || $model->scenario == 'rentApatrment'):
    ?>
    <?= $form->field($model, 'internet')->dropDownList($model->realEstateInternetList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'rentARoom' || $model->scenario == 'rentApatrment'):
    ?>
    <?= $form->field($model, 'pets_allowed')->dropDownList($model->realEstatePetsAllowedList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom'
        || $model->scenario == 'sellingApatrment' || $model->scenario == 'rentApatrment'):
    ?>
    <?= $form->field($model, 'condition')->dropDownList($model->realEstateConditionList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'rentARoom' || $model->scenario == 'rentApatrment'):
    ?>
    <?php echo $form->field($model, 'appliances')->checkboxList($model->realEstateAppliancesList,
        [
            'itemOptions' => [
                'disabled' => false,
                'divOptions' => ['class' => 'checkbox checkbox-warning']
            ]]);
    ?>
        <?php
    endif;
    ?>

    <?php /*echo $form->field($model, 'appliances')->inline()->checkboxList($model->realEstateAppliancesList,
        [
            'itemOptions' => [
                'disabled' => false,
                'divOptions' => ['class' => 'checkbox checkbox-warning checkbox-inline']
            ]]);*/
    ?>

    <?= $form->field($model, 'scenario')->hiddenInput(['value' => $model->scenario])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            [
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                //'disabled' => true
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
