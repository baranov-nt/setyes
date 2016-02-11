<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\LoginForm  */
/* @var $form ActiveForm */
?>
<div class="container">
    <div class="main-login">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-success']) ?>
                    <?= Html::a(Yii::t('app', 'Registration'), Url::to(['/main/reg']), ['class' => 'btn btn-primary']) ?>
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
</div>