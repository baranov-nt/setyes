<?php
use common\widgets\StepsNavigation\StepsNavigation;
use yii\helpers\Url;
use common\widgets\ImageLoad\ImageLoadWidget;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use justinvoelker\awesomebootstrapcheckbox\ActiveField;
use common\widgets\ImagesView\ImagesView;
use yii\widgets\Pjax;

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
    <?php
    Pjax::begin([
        'id' => 'style_forms'
        //'enablePushState' => false,
    ]);
    ?>
    <div class="col-md-3 col-md-offset-3 main-container-element <?= $modelAdRealEstate->adCategory->adMain->adStyle->main_container_class ?>">
        <div class="row">
            <div class="col-xs-12">
                <span class="<?= $modelAdRealEstate->adCategory->adMain->adStyle->favorite_icon ?> icon-favorite"></span>
                <h4 class="main-container-header-element"><?= Html::a(Yii::t('references', $modelAdRealEstate->dealType->reference_name), Url::to(['/#']), ['class' => 'main-container-header-link-element alert-link']) // операция ?></h4>
            </div>
            <div class="col-xs-12">
                <p><?= $modelAdRealEstate->place_city.', '.$modelAdRealEstate->place_street.', '.$modelAdRealEstate->place_house ?></p>
            </div>
            <div class="col-xs-12 block-padding-bottom">
                <?php
                echo ImagesView::widget(['model' => $modelAdRealEstate]);
                ?>
            </div>
            <div class="col-xs-12">
                <?= $modelAdRealEstate->contentList ?>
            </div>
            <div class="col-xs-12">
                <i class="fa fa-mobile fa-2x"></i>
                <h5><?= $user->phone ?></h5>
            </div>
            <div class="col-xs-12">
                <i class="fa fa-envelope-o fa-2x"></i>
                <h5><?= $user->email ?></h5>
            </div>
            <?php
            if($user->userProfile->first_name || $user->userProfile->second_name):
                ?>
                <div class="col-xs-12">
                    <i class="fa fa-user fa-2x" style=""></i>
                    <h5><?= $user->userProfile->first_name.' '.$user->userProfile->second_name ?></h5>
                </div>
                <?php
            endif;
            ?>
            <div class="col-xs-12">
                <?= Html::button(Yii::t('app', 'Quick view'), ['class' => $modelAdRealEstate->adCategory->adMain->adStyle->quick_view_class, 'style' => 'width: 100%;']) ?>
            </div>
        </div>
    </div>
    <?php
    Pjax::end();
    ?>

    <div class="col-md-3">
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'fieldClass' => ActiveField::className(),
            'id' => 'style_form',
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
                            $textClass = 'text-muted';
                            $radioClass = 'radio-default';
                            break;
                        case 2:
                            if($checked)
                                $checked = 'checked';
                            $bgClass = 'bg-success';
                            $textClass = 'text-success';
                            $radioClass = 'radio-success';
                            break;
                        case 3:
                            if($checked)
                                $checked = 'checked';
                            $bgClass = 'bg-info';
                            $textClass = 'text-info';
                            $radioClass = 'radio-info';
                            break;
                        case 4:
                            if($checked)
                                $checked = 'checked';
                            $bgClass = 'bg-warning';
                            $textClass = 'text-warning';
                            $radioClass = 'radio-warning';
                            break;
                        case 5:
                            if($checked)
                                $checked = 'checked';
                            $bgClass = 'bg-danger';
                            $textClass = 'text-danger';
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


