<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\ChosenAsset;
use yii\bootstrap\Dropdown;
use common\widgets\yii2TranslatePanel\components\grid\DataColumn;

ChosenAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\Profile */
/* @var $modelUser common\models\User */
/* @var $form ActiveForm */
?>
<div class="main-reg">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <img src="/images/country-flags/KG.png">
            <?php echo $form->field($model, 'country')->dropDownList($model->countriesList) ?>

            <?= $form->field($model, 'phone') ?>
            <?php
            if(($model->scenario === 'emailActivation' || $model->scenario === 'phoneAndEmailFinish') || Yii::$app->controller->action->id == 'reg'):
                ?>
                <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2">
                    <option value=""></option>
                    <option value="United States">United States</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="AF">Afghanistan +93&lt;img src="images/country-flagsAF.png" alt=""&gt;</option>
                    <option value="Afghanistan">Afghanistan</option>
                    <option value="Aland Islands">Aland Islands</option>
                    <option value="Albania">Albania</option>
                    <option value="Algeria" selected>Algeria</option>
                    <option value="American Samoa">American Samoa</option>
                    <option value="Andorra">Andorra</option>
                    <option value="Angola">Angola</option>
                    <option value="Anguilla">Anguilla</option>
                    <option value="Antarctica">Antarctica</option>
                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                    <option value="Argentina">Argentina</option>
                </select>
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
                <i> <?= Yii::t('app', '*A letter will be sent to the entered email to activate your account.') ?> </i>
                <?php
            endif;
            ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <!-- main-reg -->
</div>