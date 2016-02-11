<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\widgets\StepsNavigation\StepsNavigation;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $modelAdRealEstate common\models\AdRealEstate */
/* @var $user common\models\User */

$this->title = $modelAdRealEstate->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Real Estates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->user->identity;
?>
<div class="container" style="margin-top: 0 !important; padding-top: 0 !important;">
    <div class="col-md-12 text-center">
        <?php
        echo StepsNavigation::widget([
            'urlStep1' => Url::to(['/ad/default/index']),
            'urlStep2' => Url::to(['/ad/real-estate/update', 'id' => $modelAdRealEstate->id]),
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
            'classLinkStep1' => '',
            'classLinkStep2' => '',
            'classLinkStep3' => 'active',
            'classLinkStep4' => 'disabled',
            'classContentStep1' => 'tab-pane',
            'classContentStep2' => 'tab-pane',
            'classContentStep3' => 'tab-pane active',
            'classContentStep4' => 'tab-pane',
        ]);
        //
        ?>
    </div>
    <div class="ad-real-estate-view">

        <?= DetailView::widget([
            'model' => $modelAdRealEstate,
            'attributes' => [
                'id',
                [
                    'attribute' => 'property',
                    'value' => Yii::t('references', $modelAdRealEstate->property0->reference_name),
                ],
                [
                    'attribute' => 'deal_type',
                    'value' => Yii::t('references', $modelAdRealEstate->dealType->reference_name),
                ],
                [
                    'attribute' => 'type_of_property',
                    'value' => Yii::t('references', $modelAdRealEstate->typeOfProperty->reference_name),
                ],
                [
                    'attribute' => 'rooms_in_the_apartment',
                    'value' => Yii::t('references', $modelAdRealEstate->roomsInTheApartment->reference_name),
                ],
                [
                    'attribute' => 'material_housing',
                    'value' => Yii::t('references', $modelAdRealEstate->materialHousing->reference_name),
                ],
                [
                    'attribute' => 'floor',
                    'value' => Yii::t('references', $modelAdRealEstate->floor0->reference_name),
                ],
                [
                    'attribute' => 'floors_in_the_house',
                    'value' => Yii::t('references', $modelAdRealEstate->floorsInTheHouse->reference_name),
                ],
                [
                    'attribute' => 'area_of_property',
                    'value' => $modelAdRealEstate->area_of_property.' '.Yii::t('references', $modelAdRealEstate->measurementOfProperty->reference_name),
                ],
                [
                    'attribute' => 'area_of_land',
                    'value' => $modelAdRealEstate->area_of_land.' '.Yii::t('references', $modelAdRealEstate->measurementOfLand),
                ],
                [
                    'attribute' => 'lease_term',
                    'value' => Yii::t('references', $modelAdRealEstate->leaseTerm->reference_name),
                ],
                [
                    'attribute' => 'price',
                    'value' => $modelAdRealEstate->price.' '.Yii::t('references', $user->country->currency),
                ],
                [
                    'attribute' => 'price_for_the_period',
                    'value' => Yii::t('references', $modelAdRealEstate->priceForThePeriod->reference_name),
                ],
                [
                    'attribute' => 'necessary_furniture',
                    'value' => Yii::t('references', $modelAdRealEstate->necessaryFurniture->reference_name),
                ],
                [
                    'attribute' => 'internet',
                    'value' => Yii::t('references', $modelAdRealEstate->internet0->reference_name),
                ],
                [
                    'attribute' => 'pets_allowed',
                    'value' => Yii::t('references', $modelAdRealEstate->petsAllowed->reference_name),
                ],
                [
                    'attribute' => 'condition',
                    'value' => Yii::t('references', $modelAdRealEstate->condition0->reference_name),
                ],
                [
                    'attribute' => 'images_label',
                    'value' => $modelAdRealEstate->getImagesOfObjects(),
                ],
                [
                    'attribute' => 'temp',
                    'value' => $modelAdRealEstate->temp,
                ],
                //'place_address_id',
            ],
        ]) ?>
    </div>
</div>
