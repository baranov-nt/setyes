<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdMain */

$this->title = Yii::t('app', 'Create Ad Main');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Mains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="ad-main-create">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
