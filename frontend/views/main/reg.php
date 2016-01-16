<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\ChosenAsset;
use yii\widgets\Pjax;
use yii\authclient\widgets\AuthChoice;

ChosenAsset::register($this);
/* @var $this yii\web\View */
/* @var $model frontend\models\RegForm */
/* @var $modelUser common\models\User */
/* @var $form ActiveForm */
?>
<div class="main-reg">
    <div class="col-md-6 col-md-offset-3">
    <?php
    Pjax::begin([
        'enablePushState' => false,
    ]);
    $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-6">
                    <?php
                    $model->country_id =  \Yii::$app->getRequest()->getCookies()->getValue('_countryId');
                    echo $form->field($model, 'country_id')->dropDownList($model->countriesList, [
                        'class'  => 'form-control chosen-select',
                        'prompt' => Yii::t('app', 'Select country'),
                    ])
                    ?>
                </div>
                <div class="col-xs-6">
                    <?= $form->field($model, 'phone') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 offset6">
                    <?php
                    if(($model->scenario === 'emailActivation' || $model->scenario === 'phoneAndEmailFinish') || Yii::$app->controller->action->id == 'reg'):
                        ?>

                        <?= $form->field($model, 'email') ?>
                        <?php
                    endif;
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?php
                    if(Yii::$app->controller->action->id == 'reg'):
                        ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <?php
                    endif;
                    ?>
                </div>
                <div class="col-xs-6">
                    <?php
                    if(Yii::$app->controller->action->id == 'reg'):
                        ?>
                        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                        <?php
                    endif;
                    ?>
                </div>
            </div>

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
                <i> <?= Yii::t('app', '*A letter will be sent to the entered email to activate your account.') ?> </i>
                <?php
            endif;
            ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
        <?php
        if(Yii::$app->controller->action->id == 'reg'):
        ?>
            <label class="control-label" for="loginform-email"><?= Yii::t('app', 'Login with social network.') ?></label>
            <?php $authAuthChoice = AuthChoice::begin([
                'baseAuthUrl' => ['site/auth'],
            ]); ?>
            <?php foreach ($authAuthChoice->getClients() as $client): ?>
                <div style="width: 40px; float: left; font-size: 0px;"><?php $authAuthChoice->clientLink($client) ?></div>
            <?php endforeach; ?>
            <?php AuthChoice::end(); ?>
            <?php
        endif;
        ?>
    </div>
    <!-- main-reg -->
</div>
