<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\ChosenAsset;
use common\widgets\FontAwesome\AssetBundle;
use justinvoelker\awesomebootstrapcheckbox\ActiveField;
use yii\widgets\MaskedInput;

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

    <?php
    if($model->scenario == 'apartments' || $model->scenario == 'housesCottages' || $model->scenario == 'landPlot' ||
        $model->scenario == 'garagesParking' || $model->scenario == 'propertyAbroad' || $model->scenario == 'commercialProperty'):
    ?>
    <?= $form->field($model, 'type_of_property')->dropDownList($model->realEstatePropertyTypeList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
    <?php
    endif;
    ?>

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
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom'):
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
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom'):
        ?>
        <?= $form->field($model, 'material_housing')->dropDownList($model->realEstateMaterialHousingList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom'):
        ?>
        <?= $form->field($model, 'floor')->dropDownList($model->realEstateFloorsList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom'):
        ?>
        <?= $form->field($model, 'floors_in_the_house')->dropDownList($model->realEstateFloorsList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom'):
    ?>
    <?= $form->field($model, 'area')->textInput()->label($model->getAttributeLabel('area').' ('.$model->realEstateSystemMeasureName.')') ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'rentARoom' || $model->scenario == 'rentingARoom'):
        ?>
    <?= $form->field($model, 'lease_term')->dropDownList($model->realEstateLeaseTermList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom' || $model->scenario == 'buyRoom' || $model->scenario == 'rentingARoom'):
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
    if($model->scenario == 'rentARoom' || $model->scenario == 'rentingARoom'):
    ?>
    <?= $form->field($model, 'price_for_the_period')->dropDownList($model->realEstatePricePeriodList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'rentARoom'):
    ?>
    <?= $form->field($model, 'necessary_furniture')->dropDownList($model->realEstateNecessaryFurnitureList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'rentARoom'):
    ?>
    <?= $form->field($model, 'internet')->dropDownList($model->realEstateInternetList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'rentARoom'):
    ?>
    <?= $form->field($model, 'pets_allowed')->dropDownList($model->realEstatePetsAllowedList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'sellingRoom' || $model->scenario == 'rentARoom'):
    ?>
    <?= $form->field($model, 'condition')->dropDownList($model->realEstateConditionList, [
        'class'  => 'form-control chosen-select',
        'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'rentARoom'):
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
