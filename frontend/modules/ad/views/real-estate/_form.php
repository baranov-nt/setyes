<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdRealEstate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-real-estate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'property')->textInput() ?>

    <?= $form->field($model, 'property_type')->textInput() ?>

    <?= $form->field($model, 'category_land')->textInput() ?>

    <?= $form->field($model, 'operation_type')->textInput() ?>

    <?= $form->field($model, 'rooms_in_the_apartment')->textInput() ?>

    <?= $form->field($model, 'material_housing')->textInput() ?>

    <?= $form->field($model, 'floor')->textInput() ?>

    <?= $form->field($model, 'floors_in_the_house')->textInput() ?>

    <?= $form->field($model, 'area')->textInput() ?>

    <?= $form->field($model, 'system_measure')->textInput() ?>

    <?= $form->field($model, 'lease_term')->textInput() ?>

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
