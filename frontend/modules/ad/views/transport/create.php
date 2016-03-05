<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdTransport */

$this->title = Yii::t('app', 'Create Ad Transport');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Transports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-transport-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
