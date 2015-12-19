<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\ChosenAsset;
use common\widgets\GooglePlacesAutoComplete\GooglePlacesAutoComplete;

ChosenAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\Profile */
/* @var $modelUser common\models\User */
/* @var $form ActiveForm */
?>
<div class="main-reg">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-6">
                    <?php
                    $model->country =  \Yii::$app->getRequest()->getCookies()->getValue('_country');
                    echo $form->field($model, 'country')->dropDownList($model->countriesList, [
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
    <!-- main-reg -->
</div>
