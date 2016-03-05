<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdTransportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-transport-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'transport') ?>

    <?= $form->field($model, 'deal_type') ?>

    <?= $form->field($model, 'id_car_model') ?>

    <?= $form->field($model, 'mileage') ?>

    <?php // echo $form->field($model, 'measurement_of_mileage') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'price_for_the_period') ?>

    <?php // echo $form->field($model, 'condition') ?>

    <?php // echo $form->field($model, 'images_label') ?>

    <?php // echo $form->field($model, 'video_link') ?>

    <?php // echo $form->field($model, 'model_scenario') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
