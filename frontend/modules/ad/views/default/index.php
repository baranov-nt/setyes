<?php
use yii\bootstrap\Nav;
use common\widgets\StepsNavigation\StepsNavigation;
use yii\widgets\Pjax;
use common\widgets\Chosen\ChosenAsset;
use common\widgets\FontAwesome\AssetBundle;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $modelAdMain common\models\AdMain */

$this->title = Yii::t('app', 'Ad Real Estates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container" style="margin-top: 0 !important; padding-top: 0 !important;">
<?php
Pjax::begin([
    //'enablePushState' => false,
]);
AssetBundle::register($this);
ChosenAsset::register($this);
MaskedInput::widget([
    'name' => 'masked-input_init',
    'clientOptions' => [
        'alias' => 'decimal',
    ],
]);
?>
    <?= StepsNavigation::widget([
    'headerStep1' => Yii::t('app', 'Select Category'),
    'contentStep1' => Yii::t('app', 'Select Category: content'),
    'headerStep2' => Yii::t('app', 'Select the type of property and fill out a simple form.'),
    'contentStep2' => Yii::t('app', 'Fill in the form: content'),
    'headerStep3' => Yii::t('app', 'Add images'),
    'contentStep3' => Yii::t('app', 'Add images: content'),
    'headerStep4' => Yii::t('app', 'Post the ad'),
    'contentStep4' => Yii::t('app', 'Post the ad: content'),
    'classLinkStep1' => 'active',
    'classContentStep1' => 'tab-pane active',
    'classLinkStep2' => 'disabled',
    'classContentStep2' => 'tab-pane',
    'classLinkStep3' => 'disabled',
    'classContentStep3' => 'tab-pane',
    'classLinkStep4' => 'disabled',
    'classContentStep4' => 'tab-pane',

]); ?>
<?php
echo Nav::widget([
    'items' => $modelAdMain->mainCategoryList,
    'activateParents' => true,
    'encodeLabels' => false,
    'options' => [
        'class' => 'nav nav-pills',
    ]
]);

Pjax::end();
?>
</div>
