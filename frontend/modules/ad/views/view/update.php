<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdMain */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Ad Main',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Mains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="ad-main-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
