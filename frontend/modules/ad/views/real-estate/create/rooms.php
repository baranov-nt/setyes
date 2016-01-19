<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19.01.2016
 * Time: 17:38
 */
use yii\helpers\Html;
?>
<div class="ad-real-estate-create">
    <h1><?= Html::encode(Yii::t('references', $title)) ?></h1>
    <?= $this->render('../_form', [
        'model' => $model,
    ]) ?>
</div>