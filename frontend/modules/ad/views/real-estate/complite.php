<?php
use common\widgets\StepsNavigation\StepsNavigation;
use yii\helpers\Url;
use common\widgets\ImageLoad\ImageLoadWidget;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use justinvoelker\awesomebootstrapcheckbox\ActiveField;
use yii\widgets\Pjax;
use common\widgets\AdWidget\AdWidget;

/* @var $this yii\web\View */
/* @var $modelAdRealEstate common\models\AdRealEstate */
/* @var $user common\models\User */

$this->title = Yii::t('app', 'Step 3').': '.Yii::t('references', $modelAdRealEstate->dealType->reference_name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Real Estates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->user->identity;
?>
<div class="container" style="margin-top: 0 !important; padding-top: 0 !important;">
    <div class="col-md-12 text-center">
        <?php
        echo StepsNavigation::widget([
            'targetStep1' => '#confirm-step1',
            'urlStep1' => Url::to(['/ad/default/index', 'id' => $modelAdRealEstate->id]),
            'urlStep2' => Url::to(['/ad/real-estate/update', 'id' => $modelAdRealEstate->id]),
            'urlStep3' => Url::to(['/ad/real-estate/view', 'id' => $modelAdRealEstate->id]),
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
    $("#style_forms").on("pjax:complete", function() {
        $("#style_form").attr("tabindex",-1).focus();
    });
JS;
    $this->registerJS($js);
    echo AdWidget::widget([
        'template' => true,
        'main_container_class' => $modelAdRealEstate->adCategory->adMain->adStyle->main_container_class.' col-md-3 col-md-offset-3',
        'favorite_icon' => $modelAdRealEstate->adCategory->adMain->adStyle->favorite_icon,
        'header' => $modelAdRealEstate->dealType->reference_name,
        'address' => $modelAdRealEstate->getAddress($modelAdRealEstate),
        'images' => $modelAdRealEstate->imagesOfObjects,
        'content' => $modelAdRealEstate->contentList,
        'quick_view_class' => $modelAdRealEstate->adCategory->adMain->adStyle->quick_view_class
    ]);
    ?>
    <?php
    Pjax::end();
    ?>
    </div>

    <div class="col-md-3" style="">
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'fieldClass' => ActiveField::className(),
            'id' => 'style_form',
            'options' => ['style' => 'outline: none;']
        ]); ?>

        <?php
        //dd($modelAdRealEstate->adCategory->adMain->adStyle->id);
        echo $form->field($modelAdRealEstate->adCategory->adMain, 'ad_style_id')->radioList($modelAdRealEstate->adCategory->adMain->adStyle->styleList,
            [
                'onchange' => '
                $.pjax({
                    type: "POST",
                    url: "'.Url::to(['/ad/real-estate/select-style', 'id' => $modelAdRealEstate->id]).'",
                    data: jQuery("#style_form").serialize(),
                    container: "#style_forms",
                    push: false
                })',
                'item' => function($index, $label, $name, $checked, $value) {
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
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-12 text-center">
        <?= Html::a(Yii::t('app', 'Publish ad'), ['/ad/real-estate/publish', 'id' => $modelAdRealEstate->id], ['class' => 'btn btn-success']) ?>
    </div>
</div>


