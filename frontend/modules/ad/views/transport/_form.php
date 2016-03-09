<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use justinvoelker\awesomebootstrapcheckbox\ActiveField;
use yii\widgets\MaskedInput;
use common\widgets\GooglePlacesAutoComplete\GooglePlacesAutoComplete;
use common\widgets\ImageLoad\assets\CropperAsset;
use common\widgets\Chosen\ChosenAsset;
use common\widgets\FontAwesome\AssetBundle;
use yii\helpers\Url;

AssetBundle::register($this);
ChosenAsset::register($this);
CropperAsset::register($this);

/* @var $this yii\web\View */
/* @var $modelAdTransport common\models\AdTransport */
/* @var $user common\models\User */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $key int */
/* @var $pjaxUrl string */

$user = Yii::$app->user->identity;
?>
<div class="col-md-6 col-md-offset-3">
    <div class="ad-real-estate-form">
        <div class="row">
            <?php $form = ActiveForm::begin([
                'action' => $modelAdTransport->isNewRecord ? 'create' : Url::to(['update', 'id' => $modelAdTransport->id]),
                'method' => 'post',
                'fieldClass' => justinvoelker\awesomebootstrapcheckbox\ActiveField::className(),
                'id' => 'ad_form',
            ]); ?>

            <?php
            //d($modelAdTransport->scenario);
            ?>

            <?= $form->field($modelAdTransport, 'transport')->hiddenInput()->label(false) ?>

            <?php
            if(Yii::$app->controller->action->id != 'update'):
                ?>
                <div class="col-md-12">
                    <?= $form->field($modelAdTransport, 'deal_type')->dropDownList($modelAdTransport->transportOperationTypeList, [
                        'class'  => 'form-control chosen-select',
                        'prompt' => Yii::t('app', '---'),
                        'onChange' => '
                        $.pjax({
                            type: "POST",
                            url: "select-deal",
                            data: jQuery("#ad_form").serialize(),
                            container: "#w0",
                            push: false
                        })
                        '
                    ]) ?>
                </div>
                <?php
            endif;
            ?>
            <?php
            /** Город доступен всем операциям */
            ?>
            <?php
            if($modelAdTransport->scenario != 'rooms' && $modelAdTransport->scenario != 'apartments' && $modelAdTransport->scenario != 'houses' && $modelAdTransport->scenario != 'land'
                && $modelAdTransport->scenario != 'garages' && $modelAdTransport->scenario != 'comercial'):
                ?>
                <div class="col-md-12">
                    <?= $form->field($modelAdTransport, 'place_city')->widget(GooglePlacesAutoComplete::className(), [
                        'name' => 'place-city',
                        'value' => '',
                        'options' => [

                        ]
                    ]); ?>
                </div>
                <?= $form->field($modelAdTransport, 'place_city_validate')->hiddenInput(['value' => '1'])->label(false); ?>
                <?php
            endif;
            ?>

            <div class="col-md-12">
                <?= $form->field($modelAdTransport, 'mark')->dropDownList($modelAdTransport->passengerCarsMarksList, [
                    'class'  => 'form-control chosen-select',
                    'prompt' => Yii::t('app', '---'),
                    'onChange' => '
                        $.pjax({
                            type: "POST",
                            url: "select-mark",
                            data: jQuery("#ad_form").serialize(),
                            container: "#w0",
                            push: false
                        })
                        '
                ]) ?>
            </div>

            <div class="col-md-12">
                <?= $form->field($modelAdTransport, 'model')->dropDownList($modelAdTransport->passengerCarsModelsList, [
                    'class'  => 'form-control chosen-select',
                    'prompt' => Yii::t('app', '---'),
                    'onChange' => '
                        $.pjax({
                            type: "POST",
                            url: "select-model",
                            data: jQuery("#ad_form").serialize(),
                            container: "#w0",
                            push: false
                        })
                        '
                ]) ?>
            </div>

            <div class="col-md-12">
                <?= $form->field($modelAdTransport, 'generation')->dropDownList($modelAdTransport->passengerCarsGenerationList, [
                    'class'  => 'form-control chosen-select',
                    'prompt' => Yii::t('app', '---'),
                ]) ?>
            </div>

            <div class="col-md-12">
                <?= $form->field($modelAdTransport, 'serie')->dropDownList($modelAdTransport->passengerCarsSerieList, [
                    'class'  => 'form-control chosen-select',
                    'prompt' => Yii::t('app', '---'),
                ]) ?>
            </div>

            <div class="col-md-12">
                <?= $form->field($modelAdTransport, 'trim')->dropDownList($modelAdTransport->passengerCarsTrimList, [
                    'class'  => 'form-control chosen-select',
                    'prompt' => Yii::t('app', '---'),
                ]) ?>
            </div>

            <?php
            if(Yii::$app->user->can('Администратор') &&
                $modelAdTransport->scenario != 'rooms' && $modelAdTransport->scenario != 'apartments' && $modelAdTransport->scenario != 'houses' && $modelAdTransport->scenario != 'land'
                && $modelAdTransport->scenario != 'garages' && $modelAdTransport->scenario != 'propertyAbroad' && $modelAdTransport->scenario != 'comercial'):
                $value = '';
                if(isset($modelAdTransport->adCategory->adMain->phone_temp_ad)) {
                    $value = $modelAdTransport->adCategory->adMain->phone_temp_ad;
                }
                ?>
                <div class="col-md-12">
                    <?= $form->field($modelAdTransport, 'phone_temp_ad')->textInput(
                        [
                            'value' => $value
                        ]); ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($modelAdTransport, 'link_temp_ad')->textInput(
                        [
                            'value' => $value
                        ]);
                    ?>
                </div>
                <?php
            endif;
            ?>

            <?= $form->field($modelAdTransport, 'model_scenario')->hiddenInput(['value' => $modelAdTransport->scenario])->label(false); ?>

            <div class="col-md-12">
                <?= Html::submitButton(Yii::t('app', 'Continue'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>