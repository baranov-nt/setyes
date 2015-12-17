<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\authclient\widgets\AuthChoice;

/* @var $this yii\web\View */
/* @var $model common\models\LoginForm  */
/* @var $form ActiveForm */
?>
<div class="main-login">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <?php if($model->scenario === 'loginWithEmail'): ?>
                <?= $form->field($model, 'email') ?>
            <?php else: ?>
                <?= $form->field($model, 'phone') ?>
            <?php endif; ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?= Html::a(Yii::t('app', 'Forgot your password?'), ['/main/send-email']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-4 col-md-offset-4">
            <label class="control-label" for="loginform-email"><?= Yii::t('app', 'Login with social network.') ?></label>
            <?php $authAuthChoice = AuthChoice::begin([
                'baseAuthUrl' => ['site/auth'],
            ]); ?>
            <?php foreach ($authAuthChoice->getClients() as $client): ?>
                <div style="width: 40px; float: left; font-size: 0px;"><?php $authAuthChoice->clientLink($client) ?></div>
            <?php endforeach; ?>

            <?php AuthChoice::end(); ?>
        </div>
    </div>
</div><!-- main-login -->
