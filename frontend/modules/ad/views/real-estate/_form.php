<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\ChosenAsset;

ChosenAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\AdRealEstate */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $key int */
?>

<div class="ad-real-estate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'property')->hiddenInput()->label(false) ?>

    <?php
    if($model->scenario == 'apartments' || $model->scenario == 'housesCottages' || $model->scenario == 'landPlot' ||
        $model->scenario == 'garagesParking' || $model->scenario == 'propertyAbroad' || $model->scenario == 'commercialProperty'):
    ?>
    <?= $form->field($model, 'property_type')->dropDownList($model->realEstatePropertyTypeList, [
        'class'  => 'form-control chosen-select',
        //'prompt' => Yii::t('app', '---'),
    ]) ?>
    <?php
    endif;
    ?>

    <?= $form->field($model, 'operation_type')->dropDownList($model->realEstateOperationTypeList, [
        'class'  => 'form-control chosen-select',
        //'prompt' => Yii::t('app', '---'),
    ]) ?>

    <?php
    if($model->scenario == 'rooms' || $model->scenario == 'apartments'):
    ?>
    <?= $form->field($model, 'rooms_in_the_apartment')->dropDownList($model->realEstateRoomsInApartmentList, [
        'class'  => 'form-control chosen-select',
        //'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'rooms' || $model->scenario == 'apartments' || $model->scenario == 'housesCottages'):
        ?>
        <?= $form->field($model, 'material_housing')->dropDownList($model->realEstateMaterialHousingList, [
        'class'  => 'form-control chosen-select',
        //'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'rooms' || $model->scenario == 'apartments'):
        ?>
        <?= $form->field($model, 'floor')->dropDownList($model->realEstateFloorsList, [
        'class'  => 'form-control chosen-select',
        //'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?php
    if($model->scenario == 'rooms' || $model->scenario == 'apartments'):
        ?>
        <?= $form->field($model, 'floors_in_the_house')->dropDownList($model->realEstateFloorsList, [
        'class'  => 'form-control chosen-select',
        //'prompt' => Yii::t('app', '---'),
    ]) ?>
        <?php
    endif;
    ?>

    <?= $form->field($model, 'area')->textInput() ?>

    <?= $form->field($model, 'system_measure')->textInput() ?>

    <?= $form->field($model, 'lease_term')->dropDownList($model->realEstateLeaseTermList, [
        'class'  => 'form-control chosen-select',
        //'prompt' => Yii::t('app', '---'),
    ]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'price_period')->textInput() ?>

    <?= $form->field($model, 'furnished')->textInput() ?>

    <?= $form->field($model, 'internet')->textInput() ?>

    <?= $form->field($model, 'condition')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
