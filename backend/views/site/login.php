<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LoginForm */
/* @var $form ActiveForm */
?>
<div class="main-login">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <?php
    if($_SERVER['HTTP_HOST'] == 'admin.setyes.com'):
        echo $form->field($model, 'reCaptcha')->widget(
            \himiklab\yii2\recaptcha\ReCaptcha::className(),
            ['siteKey' => '6LcWAxMTAAAAAD2teUNSJdJ8OwfQuqIUyJJDW79j']               // your siteKey
        );
    endif;
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Sign in'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div><!-- main-login -->
