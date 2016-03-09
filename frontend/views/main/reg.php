<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\ChosenAsset;
use yii\widgets\Pjax;
use yii\authclient\widgets\AuthChoice;
use yii\widgets\MaskedInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\RegForm */
/* @var $modelUser common\models\User */
/* @var $form ActiveForm */
?>
<div class="container">
    <div class="main-reg">
        <div class="col-md-6 col-md-offset-3">
            <?php
            Pjax::begin([
                'enablePushState' => false,
            ]);
            MaskedInput::widget(['name' => 'phoneada',
                'mask' => 'asdasd',
            ]);
            ChosenAsset::register($this);
            $form = ActiveForm::begin(['action' => Url::to(['/main/reg']), 'id' => 'form', 'options' => ['data-pjax' => true]]); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            if(!isset($phoneMask)):
                                $model->country_id =  \Yii::$app->getRequest()->getCookies()->getValue('_countryId');
                            endif;
                            ?>
                            <?php
                            echo $form->field($model, 'country_id')->dropDownList($model->countriesList, [
                                'class'  => 'form-control chosen-select',
                                'prompt' => Yii::t('app', 'Select country'),
                                'onchange' => '
                                    $.pjax({
                                        type: "POST",
                                        url: "update-phone.html",
                                        data: jQuery("#form").serialize(),
                                        container: "#w0",
                                        push: false
                                    })'
                            ])
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            if($model->country_id):
                                if(!isset($phoneMask)):
                                    $phoneMask = $model->getPhoneMask();
                                endif;
                                echo $form->field($model, 'phone')->widget(MaskedInput::className(),[
                                    'name' => 'phone',
                                    'mask' => $phoneMask[0],
                                    'options' => [
                                        'placeholder' => $phoneMask[1],
                                        'class' => 'form-control'
                                    ]]);
                                ?>
                                <?php
                            else:
                                ?>
                                <?= $form->field($model, 'phone')->textInput(['class' => 'form-control disabled', 'disabled' => true]) ?>
                                <?php
                            endif;
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 offset6">
                            <?php
                            if(($model->scenario === 'emailActivation' || $model->scenario === 'phoneAndEmailFinish')
                                || Yii::$app->controller->action->id == 'reg' || Yii::$app->controller->action->id == 'update-phone'):
                                ?>

                                <?= $form->field($model, 'email') ?>
                                <?php
                            endif;
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            if(Yii::$app->controller->action->id == 'reg' || Yii::$app->controller->action->id == 'update-phone'):
                                ?>
                                <?= $form->field($model, 'password')->passwordInput() ?>
                                <?php
                            endif;
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            if(Yii::$app->controller->action->id == 'reg' || Yii::$app->controller->action->id == 'update-phone'):
                                ?>
                                <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                                <?php
                            endif;
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Registration'),
                            [
                                'class' => 'btn btn-success'
                            ]
                        )
                        ?>
                        <?= Html::a(Yii::t('app', 'Login'), Url::to(['/main/login']), ['class' => 'btn btn-primary']) ?>
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
</div>