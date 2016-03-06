<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 06.03.2016
 * Time: 17:15
 */

use common\widgets\StepsNavigation\StepsNavigation;
use yii\helpers\Url;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use justinvoelker\awesomebootstrapcheckbox\ActiveField;
use yii\widgets\Pjax;
use common\widgets\AdWidget\AdWidget;

/* @var $this yii\web\View */
/* @var $modelAdMain common\models\AdMain */
/* @var $user common\models\User */
/* @var $radioClass string */

$this->title = Yii::t('app', 'Step 4').': '.Yii::t('app', 'Publish ad');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Real Estates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->user->identity;
?>
<div class="container" style="margin-top: 0 !important; padding-top: 0 !important;">
    <div class="col-md-12 text-center">
        <?php
        echo StepsNavigation::widget([
            'targetStep1' => '#confirm-step1',
            'urlStep1' => $modelAdMain->getUrlStep1(),
            'urlStep2' => $modelAdMain->getUrlStep2(),
            'urlStep3' => $modelAdMain->getUrlStep3(),
            'urlStep4' => Url::to(['/#']),
            'titleStep1' => Yii::t('app', 'Step 1'),
            'titleStep2' => Yii::t('app', 'Step 2'),
            'titleStep3' => Yii::t('app', 'Step 3'),
            'titleStep4' => Yii::t('app', 'Complite'),
            'headerStep1' => Yii::t('app', 'Select Category'),
            'headerStep2' => Yii::t('app', 'Select the type of property and fill out a simple form.'),
            'headerStep3' => Yii::t('app', 'Add photos'),
            'headerStep4' => Yii::t('app', 'Post the ad'),
            'contentStep1' => Yii::t('app', 'Select Category: content'),
            'contentStep2' => Yii::t('app', 'Fill in the form: content'),
            'contentStep3' => Yii::t('app', 'Add images: content'),
            'contentStep4' => Yii::t('app', 'Post the ad: content'),
            'classLinkStep1' => '',
            'classLinkStep2' => '',
            'classLinkStep3' => '',
            'classLinkStep4' => 'active',
            'classContentStep1' => 'tab-pane',
            'classContentStep2' => 'tab-pane',
            'classContentStep3' => 'tab-pane',
            'classContentStep4' => 'tab-pane active',
        ]);
        //
        ?>
    </div>
    <div class="col-md-12 text-center block-padding-bottom">
        <h1><?= Yii::t('app', 'Template') ?></h1>
    </div>
    <div class="style_forms">
        <?php
        Pjax::begin([
            'id' => 'style_forms',
            'enablePushState' => true
        ]);
        $js=<<<JS
    /*$("#style_forms").on("pjax:complete", function() {
        $("#style_form").attr("tabindex",-1).focus();
    });*/
JS;
        $this->registerJS($js);
        echo AdWidget::widget([
            'template' => true,
            'id' => $modelAdMain->id,
            'author' => Yii::$app->user->can('Автор', ['model' => $modelAdMain]),
            'main_container_class' => $modelAdMain->adStyle->main_container_class.' col-md-3 col-md-offset-3',
            'favorite' => $modelAdMain->getFavorite($modelAdMain->id),
            'favorite_icon' => $modelAdMain->adStyle->favorite_icon,
            'complain' => $modelAdMain->getComplain($modelAdMain->id),
            'complain_icon' => $modelAdMain->adStyle->complain_icon,
            'header' => $modelAdMain->getHeader(),
            'address' => $modelAdMain->getAddress(),
            'address_map' => $modelAdMain->getAddressMap(),
            'phone_temp_ad' => $modelAdMain->phone_temp_ad,
            'images' => $modelAdMain->getImagesOfObjects(),
            'content' => $modelAdMain->getContentList(),
            'quick_view_class' => $modelAdMain->adStyle->quick_view_class
        ]);
        ?>
        <?php
        Pjax::end();
        ?>
    </div>

    <?php $form = ActiveForm::begin([
        'action' => Url::to(['/ad/view/publish', 'id' => $modelAdMain->id]),
        'method' => 'post',
        'fieldClass' => ActiveField::className(),
        'id' => 'style_form',
        'options' => ['style' => 'outline: none;']
    ]); ?>
    <div class="col-md-3" style="">
        <?php
        //dd($modelAdMain->adCategory->adMain->adStyle->id);
        echo $form->field($modelAdMain->adCategory->adMain, 'ad_style_id')->radioList($modelAdMain->adStyle->styleList,
            [
                'onchange' => '
                $.pjax({
                    type: "POST",
                    url: "'.Url::to(['/ad/view/select-style', 'id' => $modelAdMain->id]).'",
                    data: jQuery("#style_form").serialize(),
                    container: "#style_forms",
                    push: false
                })',
                'item' => function($index, $label, $name, $checked, $value) {
                    $radioClass = '';
                    $bgClass = '';
                    switch ($value) {
                        case 1:
                            if($checked)
                                $checked = 'checked';
                            $bgClass = 'bg-default';
                            $radioClass = 'radio-default';
                            break;
                        case 2:
                            if($checked)
                                $checked = 'checked';
                            $bgClass = 'bg-success';
                            $radioClass = 'radio-success';
                            break;
                        case 3:
                            if($checked)
                                $checked = 'checked';
                            $bgClass = 'bg-info';
                            $radioClass = 'radio-info';
                            break;
                        case 4:
                            if($checked)
                                $checked = 'checked';
                            $bgClass = 'bg-warning';
                            $radioClass = 'radio-warning';
                            break;
                        case 5:
                            if($checked)
                                $checked = 'checked';
                            $bgClass = 'bg-danger';
                            $radioClass = 'radio-danger';
                            break;
                    }
                    $return = '<div class="radio '.$radioClass.' '.$bgClass.'">';
                    $return .= '<input id="AdRealEstate-style-'.$value.'" type="radio" name="' . $name . '" value="'.$value.'" style="outline: none;" '.$checked.'>';
                    $return .= '<label for="AdRealEstate-style-'.$value.'">'.$label.'</label>';
                    $return .= '</div>';
                    return $return;
                }
            ]
        );
        ?>

    </div>
    <div class="col-md-12 text-center">
        <?= Html::hiddenInput('cityString', $modelAdMain->getCity()) ?>
        <?php
        if($modelAdMain->adCategory->adMain->temp == 1):
            ?>
            <?= Html::submitButton(Yii::t('app', 'Publish ad'), ['class' => 'btn btn-success']) ?>
            <?php
        else:
            ?>
            <?= Html::submitButton(Yii::t('app', 'Edit ad'), ['class' => 'btn btn-primary']) ?>
            <?php
        endif;
        ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>