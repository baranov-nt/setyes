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

    <?= $form->field($model, 'deal_type') ?>

    <?= $form->field($model, 'type_of_property') ?>

    <?= $form->field($model, 'place_address_id') ?>

    <?php // echo $form->field($model, 'rooms_in_the_apartment') ?>

    <?php // echo $form->field($model, 'material_housing') ?>

    <?php // echo $form->field($model, 'floor') ?>

    <?php // echo $form->field($model, 'floors_in_the_house') ?>

    <?php // echo $form->field($model, 'area_of_property') ?>

    <?php // echo $form->field($model, 'measurement_of_property') ?>

    <?php // echo $form->field($model, 'area_of_land') ?>

    <?php // echo $form->field($model, 'measurement_of_land') ?>

    <?php // echo $form->field($model, 'lease_term') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'price_for_the_period') ?>

    <?php // echo $form->field($model, 'necessary_furniture') ?>

    <?php // echo $form->field($model, 'internet') ?>

    <?php // echo $form->field($model, 'pets_allowed') ?>

    <?php // echo $form->field($model, 'condition') ?>

    <?php // echo $form->field($model, 'images_label') ?>

    <?php // echo $form->field($model, 'temp') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
