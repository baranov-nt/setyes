<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdTransport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-transport-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'transport')->textInput() ?>

    <?= $form->field($model, 'deal_type')->textInput() ?>

    <?= $form->field($model, 'id_car_model')->textInput() ?>

    <?= $form->field($model, 'mileage')->textInput() ?>

    <?= $form->field($model, 'measurement_of_mileage')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'price_for_the_period')->textInput() ?>

    <?= $form->field($model, 'condition')->textInput() ?>

    <?= $form->field($model, 'images_label')->textInput() ?>

    <?= $form->field($model, 'video_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model_scenario')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
