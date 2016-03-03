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

<div class="col-md-6 col-md-offset-3">
    <div class="ad-real-estate-form">
        <div class="row">
            <?php $form = ActiveForm::begin([
                'action' => $modelAdRealEstate->isNewRecord ? 'create' : Url::to(['update', 'id' => $modelAdRealEstate->id]),
                'method' => 'post',
                'fieldClass' => justinvoelker\awesomebootstrapcheckbox\ActiveField::className(),
                'id' => 'ad_form',
            ]); ?>

            <?php
            d($modelAdRealEstate->scenario);
            ?>

            <?= $form->field($modelAdRealEstate, 'property')->hiddenInput()->label(false) ?>


            <?php
            if(Yii::$app->controller->action->id != 'update'):
                ?>
                <div class="col-md-12">
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
                </div>
                <?php
            endif;
            ?>
            <?php
            /** Город доступен всем операциям */
            ?>
            <?php
            if($modelAdRealEstate->scenario != 'rooms' && $modelAdRealEstate->scenario != 'apartments' && $modelAdRealEstate->scenario != 'houses' && $modelAdRealEstate->scenario != 'land'
                && $modelAdRealEstate->scenario != 'garages' && $modelAdRealEstate->scenario != 'comercial'):
                ?>
                <div class="col-md-12">
                    <?= $form->field($modelAdRealEstate, 'place_city')->widget(GooglePlacesAutoComplete::className(), [
                        'name' => 'place-city',
                        'value' => '',
                        'options' => [

                        ]
                    ]); ?>
                </div>
                <?= $form->field($modelAdRealEstate, 'place_city_validate')->hiddenInput(['value' => '1'])->label(false); ?>
                <?php
            endif;
            ?>

            <?php
            if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
                || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
                || $modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse'
                || $modelAdRealEstate->scenario == 'sellingLand'
                || $modelAdRealEstate->scenario == 'sellingGarage' || $modelAdRealEstate->scenario == 'rentGarage'
                || $modelAdRealEstate->scenario == 'sellingComercial' || $modelAdRealEstate->scenario == 'rentComercial'): ?>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <?= $form->field($modelAdRealEstate, 'place_street'); ?>
                        </div>
                        <?php
                        if($modelAdRealEstate->scenario != 'sellingLand'
                            && $modelAdRealEstate->scenario != 'sellingGarage' && $modelAdRealEstate->scenario != 'rentGarage'):
                            ?>
                            <div class="col-md-4">
                                <?= $form->field($modelAdRealEstate, 'place_house'); ?>
                            </div>
                            <?php
                        endif;
                        ?>
                    </div>
                    <?= $form->field($modelAdRealEstate, 'place_address')->hiddenInput(['value' => '1'])->label(false); ?>
                </div>
                <?php
            endif;
            ?>

            <?php
            if($modelAdRealEstate->scenario == 'sellingApatrment'
                || $modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse'
                || $modelAdRealEstate->scenario == 'buyHouse' || $modelAdRealEstate->scenario == 'rentingHouse'
                || $modelAdRealEstate->scenario == 'sellingLand' || $modelAdRealEstate->scenario == 'buyLand'
                || $modelAdRealEstate->scenario == 'sellingComercial' || $modelAdRealEstate->scenario == 'rentComercial'
                || $modelAdRealEstate->scenario == 'buyComercial' || $modelAdRealEstate->scenario == 'rentingComercial'): ?>
                <div class="col-md-6">
                    <?= $form->field($modelAdRealEstate, 'type_of_property')->dropDownList($modelAdRealEstate->realEstatePropertyTypeList, [
                        'class'  => 'form-control chosen-select',
                        'prompt' => Yii::t('app', '---'),
                    ]) ?>
                </div>
                <?php
            endif;
            ?>
            <?php
            if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
                || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
                || $modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse'
                || $modelAdRealEstate->scenario == 'sellingGarage' || $modelAdRealEstate->scenario == 'rentGarage'
                || $modelAdRealEstate->scenario == 'sellingComercial' || $modelAdRealEstate->scenario == 'rentComercial'): ?>
                <div class="col-md-6">
                    <?= $form->field($modelAdRealEstate, 'area_of_property')
                        ->label($modelAdRealEstate->getAttributeLabel('area_of_property').' ('.$modelAdRealEstate->realEstateMeasurementOfPropertyName.')') ?>
                    <?= $form->field($modelAdRealEstate, 'measurement_of_property')
                        ->hiddenInput(['value' => $modelAdRealEstate->realEstateMeasurementOfPropertyId])
                        ->label(false)->error(false); ?>
                </div>
                <?php
            endif;
            ?>

            <?php
            if($modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse'
                || $modelAdRealEstate->scenario == 'sellingLand'):
                ?>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($modelAdRealEstate, 'area_of_land') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($modelAdRealEstate, 'measurement_of_land')->dropDownList($modelAdRealEstate->realEstateMeasurementOfLandName, [
                                'class'  => 'form-control chosen-select',
                                'prompt' => Yii::t('app', '---'),
                            ]) ?>
                        </div>
                    </div>
                </div>
                <?php
            endif;
            ?>

            <?php
            /** Количество комнат */
            ?>
            <?php
            if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
                || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
            ):
                ?>
                <div class="col-md-6">
                    <?= $form->field($modelAdRealEstate, 'rooms_in_the_apartment')->dropDownList($modelAdRealEstate->realEstateRoomsInApartmentList, [
                        'class'  => 'form-control chosen-select',
                        'prompt' => Yii::t('app', '---'),
                        'onChange' => ''
                    ]) ?>
                </div>
                <?php
            endif;
            ?>

            <?php
            if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
                || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
                || $modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse'
                || $modelAdRealEstate->scenario == 'sellingGarage' || $modelAdRealEstate->scenario == 'rentGarage'
                || $modelAdRealEstate->scenario == 'sellingComercial' || $modelAdRealEstate->scenario == 'rentComercial'
            ): ?>
                <div class="col-md-6">
                    <?= $form->field($modelAdRealEstate, 'material_housing')->dropDownList($modelAdRealEstate->realEstateMaterialHousingList, [
                        'class'  => 'form-control chosen-select',
                        'prompt' => Yii::t('app', '---'),
                    ]) ?>
                </div>
                <?php
            endif;
            ?>

            <?php
            if($modelAdRealEstate->scenario == 'sellingRoom' || $modelAdRealEstate->scenario == 'rentARoom'
                || $modelAdRealEstate->scenario == 'sellingApatrment' || $modelAdRealEstate->scenario == 'rentApatrment'
                || $modelAdRealEstate->scenario == 'sellingComercial' || $modelAdRealEstate->scenario == 'rentComercial'
            ):
                ?>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($modelAdRealEstate, 'floor')->dropDownList($modelAdRealEstate->realEstateFloorsList, [
                                'class'  => 'form-control chosen-select',
                                'prompt' => Yii::t('app', '---'),
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($modelAdRealEstate, 'floors_in_the_house')->dropDownList($modelAdRealEstate->realEstateFloorsInBuildingList, [
                                'class'  => 'form-control chosen-select',
                                'prompt' => Yii::t('app', '---'),
                            ]) ?>
                        </div>
                    </div>
                </div>
                <?php
            endif;
            ?>

            <?php
            /** Этажей в доме с недвижемостью (для операций с домами и недвижемостью за рубежом)*/
            ?>
            <?php
            if($modelAdRealEstate->scenario == 'sellingHouse' || $modelAdRealEstate->scenario == 'rentHouse'):
                ?>
                <div class="col-md-6">
                    <?= $form->field($modelAdRealEstate, 'floors_in_the_house')->dropDownList($modelAdRealEstate->realEstateFloorsInHouseList, [
                        'class'  => 'form-control chosen-select',
                        'prompt' => Yii::t('app', '---'),
                    ]) ?>
                </div>
                <?php
            endif;
            ?>
            <?php
            /** Срок аренды доступена */
            ?>
            <?php
            if($modelAdRealEstate->scenario == 'rentARoom'
                || $modelAdRealEstate->scenario == 'rentApatrment'
                || $modelAdRealEstate->scenario == 'rentHouse'):
                ?>
                <div class="col-md-6">
                    <?= $form->field($modelAdRealEstate, 'lease_term')->dropDownList($modelAdRealEstate->realEstateLeaseTermList, [
                        'class'  => 'form-control chosen-select',
                        'prompt' => Yii::t('app', '---'),
                    ]) ?>
                </div>
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
                <div class="clearfix"></div>
                <div class="col-md-6">
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
                        'options' => [
                            'class' => 'form-control',
                        ]
                    ])->label($modelAdRealEstate->getAttributeLabel('price').' ('.$modelAdRealEstate->realEstateCurrency.')'); ?>
                </div>
                <?php
            endif;
            ?>
            <?php
            /** Цена за период доступена для сценариев */
            ?>
            <?php
            if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentApatrment'
                || $modelAdRealEstate->scenario == 'rentHouse' || $modelAdRealEstate->scenario == 'rentGarage'
                || $modelAdRealEstate->scenario == 'rentPropertyAbroad' || $modelAdRealEstate->scenario == 'rentComercial'
            ):
                ?>
                <div class="col-md-6">
                    <?= $form->field($modelAdRealEstate, 'price_for_the_period')->dropDownList($modelAdRealEstate->realEstatePricePeriodList, [
                        'class'  => 'form-control chosen-select',
                        'prompt' => Yii::t('app', '---'),
                    ]) ?>
                </div>
                <?php
            endif;
            ?>
            <?php
            /** Необходимая мебель доступена для сценариев */
            ?>
            <?php
            if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentApatrment'
                || $modelAdRealEstate->scenario == 'rentHouse' || $modelAdRealEstate->scenario == 'rentPropertyAbroad'):
                ?>
                <div class="col-md-6">
                    <?= $form->field($modelAdRealEstate, 'necessary_furniture')->dropDownList($modelAdRealEstate->realEstateNecessaryFurnitureList, [
                        'class'  => 'form-control chosen-select',
                        'prompt' => Yii::t('app', '---'),
                    ]) ?>
                </div>
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
                <div class="col-md-6">
                    <?= $form->field($modelAdRealEstate, 'internet')->dropDownList($modelAdRealEstate->realEstateInternetList, [
                        'class'  => 'form-control chosen-select',
                        'prompt' => Yii::t('app', '---'),
                    ]) ?>
                </div>
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
                <div class="col-md-6">
                    <?= $form->field($modelAdRealEstate, 'pets_allowed')->dropDownList($modelAdRealEstate->realEstatePetsAllowedList, [
                        'class'  => 'form-control chosen-select',
                        'prompt' => Yii::t('app', '---'),
                    ]) ?>
                </div>
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
            ): ?>
                <div class="col-md-6">
                    <?= $form->field($modelAdRealEstate, 'condition')->dropDownList($modelAdRealEstate->realEstateConditionList, [
                        'class'  => 'form-control chosen-select',
                        'prompt' => Yii::t('app', '---'),
                    ]) ?>
                </div>
                <?php
            endif;
            ?>
            <?php
            if(!$modelAdRealEstate->appliances)
                $modelAdRealEstate->appliances = $modelAdRealEstate->getRealEstateAppliancesListChecked($modelAdRealEstate);
            ?>
            <?php
            /** Бытовая техника доступена для сценариев
             * 'rentARoom' 'rentApatrment' 'rentHouse' */
            ?>
            <?php
            if($modelAdRealEstate->scenario == 'rentARoom' || $modelAdRealEstate->scenario == 'rentApatrment'
                || $modelAdRealEstate->scenario == 'rentHouse' || $modelAdRealEstate->scenario == 'rentPropertyAbroad'): ?>
                <div class="col-md-6">
                    <?php echo $form->field($modelAdRealEstate, 'appliances')->checkboxList($modelAdRealEstate->realEstateAppliancesList,
                        [
                            'itemOptions' => [
                                'disabled' => false,
                                'divOptions' => ['class' => 'checkbox checkbox-warning']
                            ]]); ?>
                </div>
                <?php
            endif;
            ?>
            <?php
            if(Yii::$app->user->can('Администратор') &&
                $modelAdRealEstate->scenario != 'rooms' && $modelAdRealEstate->scenario != 'apartments' && $modelAdRealEstate->scenario != 'houses' && $modelAdRealEstate->scenario != 'land'
                && $modelAdRealEstate->scenario != 'garages' && $modelAdRealEstate->scenario != 'propertyAbroad' && $modelAdRealEstate->scenario != 'comercial'):
                $value = '';
                if(isset($modelAdRealEstate->adCategory->adMain->phone_temp_ad)) {
                    $value = $modelAdRealEstate->adCategory->adMain->phone_temp_ad;
                }
                ?>
                <div class="col-md-12">
                    <?= $form->field($modelAdRealEstate, 'phone_temp_ad')->textInput(
                        [
                            'value' => $value
                        ]); ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($modelAdRealEstate, 'link_temp_ad')->textInput(
                        [
                            'value' => $value
                        ]);
                    ?>
                </div>
                <?php
            endif;
            ?>

            <?= $form->field($modelAdRealEstate, 'model_scenario')->hiddenInput(['value' => $modelAdRealEstate->scenario])->label(false); ?>

            <div class="col-md-12">
                <?= Html::submitButton(Yii::t('app', 'Continue'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>