<?php

/**
 * @var View $this
 * @var $modelCountry common\models\Country
 */
use yii\bootstrap\ActiveForm;
use frontend\assets\ChosenAsset;

ChosenAsset::register($this);

$form = ActiveForm::begin(); ?>
<?php
echo $form->field($modelCountry, 'short_name')->dropDownList($modelCountry->countriesList, [
    'class'  => 'form-control chosen-select',
    'prompt' => Yii::t('app', 'Select country'),
    'options' => ''
])
?>
<?php ActiveForm::end(); ?>