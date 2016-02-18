<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use justinvoelker\awesomebootstrapcheckbox\ActiveField;
use yii\widgets\MaskedInput;
use common\widgets\GooglePlacesAutoComplete\GooglePlacesAutoComplete;
use common\widgets\ImageLoad\assets\CropperAsset;
use common\widgets\Chosen\ChosenAsset;
use common\widgets\FontAwesome\AssetBundle;
use yii\helpers\Url;

AssetBundle::register($this);
ChosenAsset::register($this);
CropperAsset::register($this);

/* @var $this yii\web\View */
/* @var $modelAdRealEstate common\models\AdRealEstate */
/* @var $user common\models\User */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $key int */
/* @var $pjaxUrl string */

$user = Yii::$app->user->identity;
?>


<div class="ad-real-estate-form">
    <?php $form = ActiveForm::begin([
        'action' => $modelAdRealEstate->isNewRecord ? 'create' : Url::to(['update', 'id' => $modelAdRealEstate->id]),
        'method' => 'post',
        'fieldClass' => ActiveField::className(),
        'id' => 'ad_form',
    ]); ?>

    <?php
    d($modelAdRealEstate->scenario);
    ?>

    <?= $form->field($modelAdRealEstate, 'property')->hiddenInput()->label(false) ?>

    <?php
    if(Yii::$app->controller->action->id != 'update'):
    ?>
    <?= $form->field($modelAdRealEstate, 'deal_type')->dropDownList($modelAdRealEstate->realEstateOperationTypeList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
        'onChange' => '
        $.pjax({
            type: "POST",
            url: "select-deal",
            data: jQuery("#ad_form").serialize(),
            container: "#w0",
            push: false
        })
        '
    ]) ?>
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
        || $modelAdRealEstate->scenario == 'sellingPropertyAbroad' || $modelAdRealEstate->scenario == 'rentPropertyAbroad'
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
    if($modelAdRealEstate->scenario == 'sellingGarage' || $modelAdRealEstate->scenario == 'rentGarage'
        || $modelAdRealEstate->scenario == 'buyGarage'  || $modelAdRealEstate->scenario == 'rentingGarage'
        || $modelAdRealEstate->scenario == 'buyComercial'  || $modelAdRealEstate->scenario == 'rentingComercial'
    ):
        ?>
        <?= $form->field($modelAdRealEstate, 'place_street'); ?>
        <?= $form->field($modelAdRealEstate, 'place_street_validate')->hiddenInput(['value' => '1'])->label(false); ?>
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
    /** Количество комнат доступно для сценариев
     * 'sellingRoom'  'rentARoom' 'sellingApatrment' 'rentApatrment' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
        || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
    ):
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
        || $modelAdRealEstate->scenario == 'sellingPropertyAbroad' || $modelAdRealEstate->scenario == 'rentPropertyAbroad'
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
    if($modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse'):
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
        || $modelAdRealEstate->scenario == 'sellingComercial' || $modelAdRealEstate->scenario == 'rentComercial'
    ):
        ?>
        <?= $form->field($modelAdRealEstate, 'area_of_property')->textInput(['style' => 'text-align: right !important;'])->label($modelAdRealEstate->getAttributeLabel('area_of_property').' ('.$modelAdRealEstate->realEstateMeasurementOfPropertyName.')') ?>
        <?= $form->field($modelAdRealEstate, 'measurement_of_property')->hiddenInput(['value' => $modelAdRealEstate->realEstateMeasurementOfPropertyId])->label(false); ?>
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
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    /** Срок аренды доступена для сценариев
     * 'rentARoom' 'rentApatrment' 'rentHouse' 'rentGarage' 'rentComercial' */
    ?>
    <?php
    if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentingARoom'
        || $modelAdRealEstate->scenario == 'rentApatrment' || $modelAdRealEstate->scenario == 'rentingApatrment'
        || $modelAdRealEstate->scenario == 'rentHouse' || $modelAdRealEstate->scenario == 'rentingHouse'
        || $modelAdRealEstate->scenario == 'rentGarage' || $modelAdRealEstate->scenario == 'rentingGarage'
        || $modelAdRealEstate->scenario == 'rentPropertyAbroad' || $modelAdRealEstate->scenario == 'rentComercial'
        || $modelAdRealEstate->scenario == 'buyComercial'  || $modelAdRealEstate->scenario == 'rentingComercial'
    ):
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
    if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
        || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
        || $modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse'
        || $modelAdRealEstate->scenario == 'sellingGarage' || $modelAdRealEstate->scenario == 'rentGarage'
        || $modelAdRealEstate->scenario == 'sellingLand'
        || $modelAdRealEstate->scenario == 'sellingComercial' || $modelAdRealEstate->scenario == 'rentComercial'):
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
    if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentingARoom'
        || $modelAdRealEstate->scenario == 'rentApatrment' || $modelAdRealEstate->scenario == 'rentingApatrment'
        || $modelAdRealEstate->scenario == 'rentHouse' || $modelAdRealEstate->scenario == 'rentingHouse'
        || $modelAdRealEstate->scenario == 'rentGarage'
        || $modelAdRealEstate->scenario == 'rentPropertyAbroad' || $modelAdRealEstate->scenario == 'rentComercial'
    ):
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
    if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentApatrment'
        || $modelAdRealEstate->scenario == 'rentHouse' || $modelAdRealEstate->scenario == 'rentPropertyAbroad'):
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
    if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentApatrment'
        || $modelAdRealEstate->scenario == 'rentHouse' || $modelAdRealEstate->scenario == 'rentPropertyAbroad'):
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
    if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentApatrment'
        || $modelAdRealEstate->scenario == 'rentHouse' || $modelAdRealEstate->scenario == 'rentPropertyAbroad'):
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
        || $modelAdRealEstate->scenario == 'sellingPropertyAbroad' || $modelAdRealEstate->scenario == 'rentPropertyAbroad'
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
    if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentApatrment'
        || $modelAdRealEstate->scenario == 'rentHouse' || $modelAdRealEstate->scenario == 'rentPropertyAbroad'):
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

    <?php
    if(Yii::$app->user->can('Администратор')):
        ?>
        <?php echo $form->field($modelAdRealEstate, 'phone_temp_ad')->textInput(
        [
            'value' => $modelAdRealEstate->adCategory->adMain->phone_temp_ad
        ]);
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

    <?= $form->field($modelAdRealEstate, 'model_scenario')->hiddenInput(['value' => $modelAdRealEstate->scenario])->label(false); ?>

    <div class="form-group text-center">
        <?= Html::submitButton(Yii::t('app', 'Continue'),
            [
                'class' => 'btn btn-primary',
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
