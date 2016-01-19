<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdRealEstateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-real-estate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'property') ?>

    <?= $form->field($model, 'property_type') ?>

    <?= $form->field($model, 'category_land') ?>

    <?= $form->field($model, 'operation_type') ?>

    <?php // echo $form->field($model, 'rooms_in_the_apartment') ?>

    <?php // echo $form->field($model, 'material_housing') ?>

    <?php // echo $form->field($model, 'floor') ?>

    <?php // echo $form->field($model, 'floors_in_the_house') ?>

    <?php // echo $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'system_measure') ?>

    <?php // echo $form->field($model, 'lease_term') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'price_period') ?>

    <?php // echo $form->field($model, 'furnished') ?>

    <?php // echo $form->field($model, 'internet') ?>

    <?php // echo $form->field($model, 'condition') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
