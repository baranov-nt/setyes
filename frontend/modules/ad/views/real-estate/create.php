<?php
use yii\bootstrap\Nav;
use yii\widgets\Pjax;
use yii\widgets\MaskedInput;
use common\widgets\StepsNavigation\StepsNavigation;
use yii\helpers\Url;
use common\widgets\Chosen\ChosenAsset;

/* @var $this yii\web\View */
/* @var $modelAdRealEstate common\models\AdRealEstate */
/* @var $realEstateProperty common\models\AdRealEstateReference */
/* @var $pjaxUrl string */

$this->title = Yii::t('app', 'Create Ad Real Estate');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Real Estates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container" style="margin-top: 0 !important; padding-top: 0 !important;">
<?php
Pjax::begin([
    //'enablePushState' => false,
]);
ChosenAsset::register($this);
MaskedInput::widget([
    'name' => 'masked-input_init',
    'clientOptions' => [
        'alias' => 'decimal',
    ],
]);
?>

    <div class="col-md-12 text-center">

    <?php
echo StepsNavigation::widget([
    'targetStep1' => '#confirm-step1',
    'urlStep1' => Url::to(['/ad/default/index']),
    'urlStep2' => Url::to(['/#']),
    'urlStep3' => Url::to(['/#']),
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
    'classLinkStep2' => 'active',
    'classLinkStep3' => 'disabled',
    'classLinkStep4' => 'disabled',
    'classContentStep1' => 'tab-pane',
    'classContentStep2' => 'tab-pane active',
    'classContentStep3' => 'tab-pane',
    'classContentStep4' => 'tab-pane',
]);
//
echo Nav::widget([
    'items' => $modelAdRealEstate->realEstatePropertyList,
    'activateParents' => true,
    'encodeLabels' => false,
    'options' => [
        'class' => 'nav nav-tabs',
    ]
]);
?>
    </div>
<?php if($modelAdRealEstate->scenario != 'default'):
    ?>
    <?= $this->render('_form', [
        'modelAdRealEstate' => $modelAdRealEstate,
    ]);
    ?>
<?php
endif;
?>
<?php
Pjax::end();
?>
</div>
