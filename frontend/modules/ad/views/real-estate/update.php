<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\widgets\StepsNavigation\StepsNavigation;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $modelAdRealEstate common\models\AdRealEstate */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Ad Real Estate',
    ]) . ' ' . $modelAdRealEstate->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Real Estates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelAdRealEstate->id, 'url' => ['view', 'id' => $modelAdRealEstate->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="container" style="margin-top: 0 !important; padding-top: 0 !important;">
    <div class="col-md-12 text-center">
        <?php
        echo StepsNavigation::widget([
            'urlStep1' => Url::to(['/ad/default/index']),
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
    <div class="ad-real-estate-update">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'modelAdRealEstate' => $modelAdRealEstate,
        ]) ?>
    </div>
</div>
