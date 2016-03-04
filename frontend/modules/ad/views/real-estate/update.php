<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\widgets\StepsNavigation\StepsNavigation;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $modelAdRealEstate common\models\AdRealEstate */

$this->title = Yii::t('app', 'Step 2').': '.Yii::t('app', 'Edit ad').' '.Yii::t('references', $modelAdRealEstate->dealType->reference_name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Real Estates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelAdRealEstate->id, 'url' => ['view', 'id' => $modelAdRealEstate->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="container" style="margin-top: 0 !important; padding-top: 0 !important;">
    <div class="col-md-12 text-center">
        <?php
        echo StepsNavigation::widget([
            'targetStep1' => '#confirm-step1',
            'urlStep1' => Url::to(['/ad/default/index']),
            'urlStep2' => Url::to(['/ad/real-estate/update', 'id' => $modelAdRealEstate->id]),
            'urlStep3' => Url::to(['/ad/real-estate/view', 'id' => $modelAdRealEstate->id]),
            'urlStep4' => Url::to(['/#']),
            'titleStep1' => Yii::t('app', 'Step 1'),
            'titleStep2' => Yii::t('app', 'Step 2'),
            'titleStep3' => Yii::t('app', 'Step 3'),
            'titleStep4' => Yii::t('app', 'Complite'),
            'headerStep1' => Yii::t('app', 'Select Category'),
            'headerStep2' => Yii::t('app', 'Edit ad'),
            'headerStep3' => Yii::t('app', 'Add photos'),
            'headerStep4' => Yii::t('app', 'Post the ad'),
            'contentStep1' => Yii::t('app', 'Select Category: content'),
            'contentStep2' => Yii::t('app', 'Fill in the form: content'),
            'contentStep3' => Yii::t('app', 'Add images: content'),
            'contentStep4' => Yii::t('app', 'Post the ad: content'),
            'classLinkStep1' => '',
            'classLinkStep2' => 'active',
            'classLinkStep3' => '',
            'classLinkStep4' => 'disabled',
            'classContentStep1' => 'tab-pane',
            'classContentStep2' => 'tab-pane active',
            'classContentStep3' => 'tab-pane',
            'classContentStep4' => 'tab-pane',
        ]);
        //
        ?>
    </div>
    <h1 class="text-center" style="margin-bottom: 40px;"><?= Html::encode($this->title) ?></h1>
    <div class="ad-real-estate-update">
        <?= $this->render('_form', [
            'modelAdRealEstate' => $modelAdRealEstate,
        ]) ?>
    </div>
</div>
