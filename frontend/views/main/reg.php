<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */
/* @var $modelUser common\models\User */
/* @var $form ActiveForm */
?>
<div class="main-reg">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <?= $form->field($model, 'phone')->widget(MaskedInput::className(),[
                'name' => 'phone',
                'mask' => '7 (999) 999-9999',
                'options' => [
                    'placeholder' => '7 (___) ___-____',
                    'class' => 'form-control'
                ]]) ?>
            <?php
            if(($model->scenario === 'emailActivation' || $model->scenario === 'phoneAndEmailFinish') || Yii::$app->controller->action->id == 'reg'):
                ?>
                <?= $form->field($model, 'email') ?>
                <?php
            endif;
            ?>
            <?php
            if(Yii::$app->controller->action->id == 'reg'):
                ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?php
            endif;
            ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::$app->controller->action->id == 'reg' ? Yii::t('app', 'Registration') : Yii::t('app', 'Complete Registration'),
                    [
                        'class' => Yii::$app->controller->action->id == 'reg' ? 'btn btn-primary' : 'btn btn-success'
                    ]
                )
                ?>
            </div>
            <?php
            if($model->scenario === 'emailActivation' || $model->scenario === 'phoneAndEmailFinish'):
                ?>
                <i> <?= Yii::t('app', '*A valid email will be sent an email to activate your account.') ?> </i>
                <?php
            endif;
            ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <!-- main-reg -->
</div>