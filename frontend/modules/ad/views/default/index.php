<?php
use yii\bootstrap\Nav;
use common\widgets\StepsNavigation\StepsNavigation;
use yii\widgets\Pjax;
use common\widgets\Chosen\ChosenAsset;
use common\widgets\FontAwesome\AssetBundle;
use yii\widgets\MaskedInput;
use yii\helpers\Url;
use yii\bootstrap\Html;
/* @var $this yii\web\View */
/* @var $modelAdMain common\models\AdMain */

$this->title = Yii::t('app', 'Post ad').': '.Yii::t('app', 'Select Category');
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
        'targetStep1' => '',
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
        'headerStep3' => Yii::t('app', 'Add images'),
        'headerStep4' => Yii::t('app', 'Post the ad'),
        'contentStep1' => Yii::t('app', 'Select Category: content'),
        'contentStep2' => Yii::t('app', 'Fill in the form: content'),
        'contentStep3' => Yii::t('app', 'Add images: content'),
        'contentStep4' => Yii::t('app', 'Post the ad: content'),
        'classLinkStep1' => 'active',
        'classLinkStep2' => 'disabled',
        'classLinkStep3' => 'disabled',
        'classLinkStep4' => 'disabled',
        'classContentStep1' => 'tab-pane active',
        'classContentStep2' => 'tab-pane',
        'classContentStep3' => 'tab-pane',
        'classContentStep4' => 'tab-pane',
    ]); ?>
    <h1 class="text-center" style="margin-bottom: 40px;"><?= Html::encode($this->title) ?></h1>
    <div class="col-md-12 text-center">
        <?php
        echo Nav::widget([
            'items' => $modelAdMain->mainCategoryList,
            'activateParents' => true,
            'encodeLabels' => false,
            'options' => [
                'class' => 'nav nav-pills',
            ]
        ]);
        ?>
    </div>
<?php
Pjax::end();
?>
</div>
